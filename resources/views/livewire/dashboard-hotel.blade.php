<div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Room</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="book-open"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ count($room) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Room Occupied</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $roomOccupied }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Room Empty</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $roomEmpty }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <h1 class="h3 mb-3">
                Guest Data
            </h1>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Guest Data</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Guest Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($room as $ro)
                                    <tr>
                                        <td>{{ $ro->no }}</td>
                                        <td>{!! $ro->guest_name ?? '<span class="text-danger">Empty</span>' !!}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
