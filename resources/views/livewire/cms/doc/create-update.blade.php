<div>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <x-acc-form submit="customSave">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Menu</label>
                        <select class="form-control" wire:model="form.menu_id">
                            <option value="">--Select Menu--</option>
                            @foreach ($menus as $m)
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>
                        <x-acc-input-error for="form.menu_id" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" wire:model="form.title" class="form-control" placeholder="Title">
                        <x-acc-input-error for="form.title" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <x-acc-trix-editor-upload model_name="trix_content" :model="$trix_content" :can_upload="true" />
                        <x-acc-input-error for="form.content" />
                    </div>
                </div>
            </x-acc-form>
        </div>
    </div>
</div>
