<div>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <x-acc-form submit="save">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Email Notification</label>
                        <input type="email" wire:model.live="form.email_notification" class="form-control" placeholder="Email Notification">
                        <x-acc-input-error for="form.email_notification" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wa Notification</label>
                        <input type="text" wire:model.live="form.wa_notification" class="form-control" placeholder="Wa Notification">
                        <x-acc-input-error for="form.wa_notification" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telegram Notification</label>
                        <input type="text" wire:model.live="form.telegram_notification" class="form-control" placeholder="Telegram Notification">
                        <x-acc-input-error for="form.telegram_notification" />
                    </div>
                </div>
            </x-acc-form>
        </div>
    </div>
</div>
