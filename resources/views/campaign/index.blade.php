@include('includes.head')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            overflow: hidden;
            border-radius: 10px;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
        }

        .btn-edit {
            background-color: #ffc107;
            color: white;
        }

        .btn-tutup {
            background-color: #dc3545;
            color: white;
        }
    </style>
    @include('includes.header')
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <div class="col-md-9">
                <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal" data-bs-target="#createcampaign">
                    Create Campaign
                </button>
                <table class="table table-bordered mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Campaign</th>
                            <th>Creator</th>
                            <th>Lokasi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Target</th>
                            <th>Terkumpul</th>
                            <th>Status</th>
                            <th>Approved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign['id'] }}</td>
                            <td>{{ $campaign['campaign_name'] }}</td>
                            <td>{{ $campaign['creator'] ?? 'Lazismu DIY' }}</td>
                            <td>{{ $campaign['location'] }}</td>
                            <td>{{ $campaign['start_date'] }} - {{ $campaign['end_date'] }}</td>
                            <td>{{ number_format($campaign['target_amount']) }}</td>
                            <td>{{ number_format($campaign['current_amount']) }}</td>
                            <td><span class="text-success">Aktif</span></td>
                            <td>
                                <button class="btn btn-approve btn-sm">Approve</button>
                            </td>
                            <td>
                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editCampaign{{ $campaign['id'] }}">Edit</button>
                                <button class="btn btn-tutup btn-sm">Tutup</button>
                            </td>
                        </tr>

                        <!-- Modal Edit Campaign-->
                        <div class="modal fade" id="editCampaign{{ $campaign['id'] }}" tabindex="-1" aria-labelledby="editCampaignLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editCampaignLabel">Edit Campaign</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('campaign.update', $campaign['id']) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="campaign_category_id" class="form-label">Category</label>
                                                <select class="form-select" name="campaign_category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category['id'] }}" {{ $campaign['campaign_category_id'] == $category['id'] ? 'selected' : '' }}>
                                                            {{ $category['campaign_category'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="campaign_name" class="form-control" placeholder="Campaign Name" value="{{ $campaign['campaign_name'] }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="campaign_code" class="form-control" placeholder="Code Campaign" value="{{ $campaign['campaign_code'] }}" required>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea name="description" class="form-control" placeholder="Deskripsi" id="floatingTextarea" style="height: 100px;" required>{{ $campaign['description'] }}</textarea>
                                                <label for="floatingTextarea">Deskripsi</label>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="location" class="form-control" placeholder="Lokasi" value="{{ $campaign['location'] }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" name="target_amount" class="form-control" placeholder="Target Amount" value="{{ $campaign['target_amount'] }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                                <input type="date" name="start_date" class="form-control" value="{{ $campaign['start_date'] }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="endDate" class="form-label">Tanggal Selesai</label>
                                                <input type="date" name="end_date" class="form-control" value="{{ $campaign['end_date'] }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="campaign_thumbnail" class="form-label">Thumbnail</label>
                                                <input class="form-control" type="file" name="campaign_thumbnail" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label for="campaign_image1" class="form-label">Image 1</label>
                                                <input class="form-control" type="file" name="campaign_image1" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label for="campaign_image2" class="form-label">Image 2</label>
                                                <input class="form-control" type="file" name="campaign_image2" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label for="campaign_image3" class="form-label">Image 3</label>
                                                <input class="form-control" type="file" name="campaign_image3" accept="image/*">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>

                <!-- Modal Create Campaign-->
                <div class="modal fade" id="createcampaign" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Campaign</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="campaign_category_id" class="form-label">Category</label>
                                        <select class="form-select" name="campaign_category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['campaign_category'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="campaign_name" class="form-control" placeholder="Campaign Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="campaign_code" class="form-control" placeholder="Code Campaign" required>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea name="description" class="form-control" placeholder="Deskripsi" id="floatingTextarea" style="height: 100px;" required></textarea>
                                        <label for="floatingTextarea">Deskripsi</label>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="location" class="form-control" placeholder="Lokasi" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" name="target_amount" class="form-control" placeholder="Target Amount" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="startDate" class="form-label">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="endDate" class="form-label">Tanggal Selesai</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="campaign_thumbnail" class="form-label">Thumbnail</label>
                                        <input class="form-control" type="file" name="campaign_thumbnail" accept="image/*" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="campaign_image1" class="form-label">Image 1</label>
                                        <input class="form-control" type="file" name="campaign_image1" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="campaign_image2" class="form-label">Image 2</label>
                                        <input class="form-control" type="file" name="campaign_image2" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="campaign_image3" class="form-label">Image 3</label>
                                        <input class="form-control" type="file" name="campaign_image3" accept="image/*">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
