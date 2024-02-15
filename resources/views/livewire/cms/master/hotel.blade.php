<div>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-acc-header :$originRoute />
                <table class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <x-acc-loop-th :$searchBy :$orderBy :$order />
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($get as $d)
                            <tr>
                                <td>{{ $d->name }}</td>
                                <td>{{ $d->branch }}</td>
                                <td>{{ $d->address }}</td>
                                <td>{{ $d->phone }}</td>
                                <td>{{ $d->email }}</td>
                                <td>{{ $d->website }}</td>
                                <td>{{ $d->default_greeting }}</td>
                                <td>{{ $d->password_setting }}</td>
                                <td>{{ $d->is_active }}</td>
                                <x-acc-update-delete :id="$d->id" :$originRoute>
                                    <button
                                        class="btn btn-primary"
                                        wire:click="getProfile({{ $d->id }})"
                                        @click="new bootstrap.Modal(document.getElementById('acc-profile')).show()">
                                        <i class="align-middle" data-feather="edit"></i> Profile
                                    </button>
                                </x-acc-update-delete>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100" class="text-center">
                                    No Data Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="float-end">
                    {{ $get->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}">
        <x-acc-form submit="save">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.name" class="form-control" placeholder="Name">
                    <x-acc-input-error for="form.name" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Branch</label>
                    <input type="text" wire:model="form.branch" class="form-control" placeholder="Branch">
                    <x-acc-input-error for="form.branch" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" wire:model="form.address" class="form-control" placeholder="Address">
                    <x-acc-input-error for="form.address" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="number" wire:model="form.phone" class="form-control" placeholder="Phone">
                    <x-acc-input-error for="form.phone" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" wire:model="form.email" class="form-control" placeholder="Email">
                    <x-acc-input-error for="form.email" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="text" wire:model="form.website" class="form-control" placeholder="Website">
                    <x-acc-input-error for="form.website" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Default Greeting</label>
                    <input type="text" wire:model="form.default_greeting" class="form-control" placeholder="Default Greeting">
                    <x-acc-input-error for="form.default_greeting" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Setting</label>
                    <input type="text" wire:model="form.password_setting" class="form-control" placeholder="Password Setting">
                    <x-acc-input-error for="form.password_setting" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Is Active</label>
                    <select wire:model="form.is_active" class="form-control">
                        <option value="">--Is Active--</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <x-acc-input-error for="form.is_active" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>

    <x-acc-modal title="Edit Profile" id="acc-profile">
        <x-acc-form submit="saveProfile">
            <input type="hidden" wire:model="formProfile.hotel_id">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Hotel</label>
                    <input type="text" wire:model="formProfile.hotel" class="form-control" placeholder="Hotel">
                    <x-acc-input-error for="formProfile.hotel" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Primary Color</label>
                    <input type="text" wire:model="formProfile.primary_color" class="form-control" placeholder="Primary Color">
                    <x-acc-input-error for="formProfile.primary_color" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input id="id_trix_description" type="hidden" name="trix_description" value="{{ $trix_description }}">
                    <trix-editor wire:ignore input="id_trix_description" class="trix-content"></trix-editor>
                    <x-acc-input-error for="formProfile.description" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Logo Color</label>
                    <x-acc-image-preview :image="$logo_color" :form_image="$formProfile->logo_color"  />
                    <x-acc-upload-progress>
                        <input type="file" wire:model="logo_color" class="form-control">
                    </x-acc-upload-progress>
                    <x-acc-input-error for="formProfile.logo_color" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Logo White</label>
                    <x-acc-image-preview :image="$logo_white" :form_image="$formProfile->logo_white"  />
                    <x-acc-upload-progress>
                        <input type="file" wire:model="logo_white" class="form-control">
                    </x-acc-upload-progress>
                    <x-acc-input-error for="formProfile.logo_white" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Logo Black</label>
                    <x-acc-image-preview :image="$logo_black" :form_image="$formProfile->logo_black"  />
                    <x-acc-upload-progress>
                        <input type="file" wire:model="logo_black" class="form-control">
                    </x-acc-upload-progress>
                    <x-acc-input-error for="formProfile.logo_black" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Main Photo</label>
                    <x-acc-image-preview :image="$main_photo" :form_image="$formProfile->main_photo"  />
                    <x-acc-upload-progress>
                        <input type="file" wire:model="main_photo" class="form-control">
                    </x-acc-upload-progress>
                    <x-acc-input-error for="formProfile.main_photo" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Background Photo</label>
                    <x-acc-image-preview :image="$background_photo" :form_image="$formProfile->background_photo"  />
                    <x-acc-upload-progress>
                        <input type="file" wire:model="background_photo" class="form-control">
                    </x-acc-upload-progress>
                    <x-acc-input-error for="formProfile.background_photo" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Intro Video</label>
                    <x-acc-video-preview :video="$intro_video" :form_video="$formProfile->intro_video"  />
                    <x-acc-upload-progress>
                        <input type="file" wire:model="intro_video" class="form-control">
                    </x-acc-upload-progress>
                    <x-acc-input-error for="formProfile.intro_video" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
    <x-slot:scripts>
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
        <script>
            const trixEditor = document.getElementById('id_trix_description')
            const mimeTypes = ['image/png', 'image/jpeg', 'image/jpg']

            addEventListener('trix-blur', ev => {
                @this.set('trix_description', trixEditor.getAttribute('value'))
            })

            addEventListener('trix-file-accept', ev => {
                if (!mimeTypes.includes(ev.file.type)) {
                    // file type not allowed, prevent default upload
                    return ev.preventDefault()
                }
            })

            addEventListener('trix-attachment-add', ev => {
                console.log('Gabisa bg')
            })
        </script>
    </x-slot:scripts>
</div>
