#!/bin/bash

# Deployment script to update server files with only changed files from git repository
# Usage: ./deploy.sh

PROJECT_DIR="/home/isoladmin/test-hotel"
REPO_URL="https://github.com/manch93/isolutions-hotels-backend.git"
BACKUP_DIR="/home/isoladmin/test-hotel-backup"

echo "🚀 Starting smart deployment process..."

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Navigate to project directory
cd $PROJECT_DIR

# Check if git repository exists
if [ ! -d ".git" ]; then
    echo "❌ No git repository found. Please initialize git first."
    exit 1
fi

# Create backup of changed files only
TIMESTAMP=$(date +%Y%m%d-%H%M%S)
echo "📦 Backing up potentially changed files..."
git diff --name-only HEAD origin/main > /tmp/changed_files_$TIMESTAMP.txt
if [ -s /tmp/changed_files_$TIMESTAMP.txt ]; then
    mkdir -p $BACKUP_DIR/backup-$TIMESTAMP
    while IFS= read -r file; do
        if [ -f "$file" ]; then
            mkdir -p "$BACKUP_DIR/backup-$TIMESTAMP/$(dirname "$file")"
            cp "$file" "$BACKUP_DIR/backup-$TIMESTAMP/$file"
        fi
    done < /tmp/changed_files_$TIMESTAMP.txt
    echo "📁 Backup created at: $BACKUP_DIR/backup-$TIMESTAMP"
else
    echo "ℹ️ No files to backup - repository is up to date"
fi

# Fetch latest changes
echo "📡 Fetching latest changes..."
git fetch origin

# Check if there are any changes
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/main)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "✅ Repository is already up to date!"
    exit 0
fi

# Show what will be changed
echo "📋 Changes to be applied:"
git log --oneline HEAD..origin/main
echo ""
echo "📄 Files that will be modified:"
git diff --name-only HEAD origin/main

# Ask for confirmation (optional - remove if you want automatic deployment)
read -p "🤔 Do you want to proceed with the update? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Deployment cancelled"
    exit 1
fi

# Stop services only if there are PHP/config changes
echo "🔍 Checking if services need to be restarted..."
RESTART_NEEDED=false
if git diff --name-only HEAD origin/main | grep -E "\.(php|env|conf|ini)$"; then
    RESTART_NEEDED=true
    echo "🛑 Stopping services (PHP files changed)..."
    sudo systemctl stop nginx
    sudo systemctl stop php8.1-fpm
fi

# Pull only the changes (merge strategy)
echo "🔄 Applying changes from repository..."
git merge origin/main --no-edit

# Check if composer.json or composer.lock changed
if git diff --name-only HEAD^..HEAD | grep -E "composer\.(json|lock)$"; then
    echo "📚 Composer files changed - updating dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Check if migrations were added
if git diff --name-only HEAD^..HEAD | grep "database/migrations/"; then
    echo "🗃️ New migrations detected - running migrations..."
    php artisan migrate --force
fi

# Clear caches only if needed
if git diff --name-only HEAD^..HEAD | grep -E "(routes/|config/|\.php$)"; then
    echo "🧹 Clearing caches (code changes detected)..."
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan optimize
fi

# Set permissions for any new files
echo "🔐 Setting permissions..."
sudo chown -R www-data:www-data $PROJECT_DIR
sudo chmod -R 755 $PROJECT_DIR
sudo chmod -R 775 $PROJECT_DIR/storage
sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache

# Restart services if they were stopped
if [ "$RESTART_NEEDED" = true ]; then
    echo "🚀 Starting services..."
    sudo systemctl start php8.1-fpm
    sudo systemctl start nginx
fi

echo "✅ Smart deployment completed successfully!"
echo "📊 Summary:"
echo "   - Repository updated from $LOCAL to $REMOTE"
if [ -f /tmp/changed_files_$TIMESTAMP.txt ]; then
    echo "   - Files changed: $(wc -l < /tmp/changed_files_$TIMESTAMP.txt)"
    echo "   - Backup created at: $BACKUP_DIR/backup-$TIMESTAMP"
fi
rm -f /tmp/changed_files_$TIMESTAMP.txt
