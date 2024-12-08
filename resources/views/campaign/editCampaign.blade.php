<div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-20 flex items-center justify-center" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" @click="isOpen = false"></div>

    <!-- Modal content -->
    <div
        class="ml-56 mt-14 relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-6 overflow-hidden transform transition-all">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 mb-3" id="modal-title">Edit
                Campaign
            </h3>
            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                &#10005;
            </button>
        </div>

        <!-- Formulir Campaign -->
        <form id="edit-campaign-form" action="{{ route('campaign.update', $campaign['id']) }}" method="POST"
            enctype="multipart/form-data" class="h-96 overflow-y-auto">
            @csrf
            {{-- @method('PUT') --}}
            <input type="hidden" name="_method" value="PUT">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Pilih Kategori -->
                <div>
                    <label for="campaign_category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori
                        campaign</label>
                    <select name="campaign_category_id" id="campaign_category_id"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}"
                                {{ request('category') == $category['id'] ? 'selected' : '' }}>
                                {{ $category['campaign_category'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Campaign -->


                <div>
                    <label for="campaign_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                        campaign</label>
                    <input type="text" name="campaign_name" id="campaign_name"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        placeholder="Masukkan nama campaign..." value="{{ $campaign['campaign_name'] }}">
                </div>
                <div>
                    <label for="campaign_code" class="block text-sm font-medium text-gray-700 mb-2">Kode
                        Campaign</label>
                    <input type="text" name="campaign_code" id="campaign_code"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        placeholder="Masukkan kode campaign..." value="{{ $campaign['campaign_code'] }}">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi
                        Campaign</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border px-2"
                        placeholder="Masukkan deskripsi campaign...">{{ $campaign['description'] }}</textarea>
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" id="location"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        placeholder="Masukkan lokasi..." value="{{ $campaign['location'] }}">
                </div>
                <div class="relative">
                    <label for="formatted_target_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Target donasi (Rp):
                    </label>
                    <!-- Wrapper untuk input -->
                    <div class="relative mt-1">
                        <!-- Label Rp di dalam input -->
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                            Rp
                        </span>
                        <!-- Input Tampilan -->
                        <input type="text" id="formatted_target_amount"
                            class="pl-10 pr-3 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                            placeholder="Masukkan target donasi..."
                            value="{{ number_format($campaign['target_amount'], 0, ',', '.') }}">
                    </div>
                    <!-- Input Nilai Asli (Tersembunyi) -->
                    <input type="hidden" name="target_amount" id="target_amount"
                        value="{{ $campaign['target_amount'] }}">
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                        mulai</label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        required value="{{ $campaign['start_date'] }}">
                </div>

                <!-- Thumbnail Campaign -->
                <div>
                    <label for="campaign_thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        Thumbnail Campaign
                        <span class="italic text-xs">(Hanya file JPEG, JPG, atau PNG, max 2MB)</span>
                    </label>
                    <input type="file" name="campaign_thumbnail" id="campaign_thumbnail"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/*">

                    <!-- Preview Thumbnail -->
                    <div id="previewContainerThumbnail"
                        class="relative mt-3 w-40 h-auto rounded-lg border border-gray-300 {{ empty($campaign['campaign_thumbnail']) ? 'hidden' : '' }}">
                        <img id="thumbnailPreview" src="{{ $campaign['campaign_thumbnail'] ?? '' }}"
                            alt="Preview Thumbnail" class="w-full h-auto">
                        <button id="resetButtonThumbnail" type="button"
                            class="absolute top-1 right-1 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                    <p id="thumbnailerror" class="hidden text-sm text-red-500 mt-1">Ukuran file tidak boleh lebih
                        dari 2MB!</p>
                </div>

                <!-- Campaign Image 1 -->
                <div>
                    <label for="campaign_image1" class="block text-sm font-medium text-gray-700 mb-2">
                        Campaign Image 1
                        <span class="italic text-xs">(Hanya file JPEG, JPG, atau PNG, max 2MB)</span>
                    </label>
                    <input type="file" name="campaign_image_1" id="campaign_image1"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/*">

                    <!-- Preview Campaign Image 1 -->
                    <div id="previewContainerImage1"
                        class="relative mt-3 w-40 h-auto rounded-lg border border-gray-300 {{ empty($campaign['campaign_image_1']) ? 'hidden' : '' }}">
                        <img id="image1Preview" src="{{ $campaign['campaign_image_1'] ?? '' }}"
                            alt="Preview Campaign Image 1" class="w-full h-auto">
                        <button id="resetButtonImage1" type="button"
                            class="absolute top-1 right-1 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                    <p id="campaignimage1error" class="hidden text-sm text-red-500 mt-1">Ukuran file tidak boleh
                        lebih dari 2MB!</p>
                </div>

                <!-- Campaign Image 2 -->
                <div>
                    <label for="campaign_image2" class="block text-sm font-medium text-gray-700 mb-2">
                        Campaign Image 2
                        <span class="italic text-xs">(Hanya file JPEG, JPG, atau PNG, max 2MB)</span>
                    </label>
                    <input type="file" name="campaign_image_2" id="campaign_image2"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/*">

                    <!-- Preview Campaign Image 2 -->
                    <div id="previewContainerImage2"
                        class="relative mt-3 w-40 h-auto rounded-lg border border-gray-300 {{ empty($campaign['campaign_image_2']) ? 'hidden' : '' }}">
                        <img id="image2Preview" src="{{ $campaign['campaign_image_2'] ?? '' }}"
                            alt="Preview Campaign Image 2" class="w-full h-auto">
                        <button id="resetButtonImage2" type="button"
                            class="absolute top-1 right-1 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                    <p id="campaignimage2error" class="hidden text-sm text-red-500 mt-1">Ukuran file tidak boleh
                        lebih dari 2MB!</p>
                </div>

                <!-- Campaign Image 3 -->
                <div>
                    <label for="campaign_image3" class="block text-sm font-medium text-gray-700 mb-2">
                        Campaign Image 3
                        <span class="italic text-xs">(Hanya file JPEG, JPG, atau PNG, max 2MB)</span>
                    </label>
                    <input type="file" name="campaign_image_3" id="campaign_image3"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/*">

                    <!-- Preview Campaign Image 3 -->
                    <div id="previewContainerImage3"
                        class="relative mt-3 w-40 h-auto rounded-lg border border-gray-300 {{ empty($campaign['campaign_image_3']) ? 'hidden' : '' }}">
                        <img id="image3Preview" src="{{ $campaign['campaign_image_3'] ?? '' }}"
                            alt="Preview Campaign Image 3" class="w-full h-auto">
                        <button id="resetButtonImage3" type="button"
                            class="absolute top-1 right-1 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                    <p id="campaignimage3error" class="hidden text-sm text-red-500 mt-1">Ukuran file tidak boleh
                        lebih dari 2MB!</p>
                </div>



            </div>

            <!-- Tombol Batal dan Simpan -->
            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" @click="isOpen = false; resetForm()"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

{{-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('change', function(event) {
            // Untuk campaign thumbnail
            if (event.target && event.target.id === 'campaign_thumbnail') {
                const thumbnailInput = event.target;
                const previewContainer = document.getElementById('previewContainerThumbnail');
                const thumbnailPreview = document.getElementById('thumbnailPreview');
                const errorMessage = document.getElementById('thumbnailerror');

                const file = thumbnailInput.files[0];

                if (file) {
                    // Validasi ukuran file (maksimum 2MB)
                    if (file.size >= 2 * 1024 * 1024) {
                        errorMessage.textContent =
                            "Ukuran file tidak boleh lebih dari 2MB!"; // Tampilkan pesan error
                        errorMessage.classList.remove('hidden');
                        thumbnailInput.value = ''; // Reset input file
                        previewContainer.classList.add('hidden');
                    } else {
                        errorMessage.classList.add('hidden'); // Sembunyikan pesan error
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            thumbnailPreview.src = e.target.result; // Tampilkan preview gambar baru
                            previewContainer.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }

            // Untuk campaign image 1
            if (event.target && event.target.id === 'campaign_image1') {
                const imageInputCampaign1 = event.target;
                const previewContainerCampaign1 = document.getElementById('previewContainerImage1');
                const imagePreviewCampaign1 = document.getElementById('image1Preview');
                const errorMessageCampaign1 = document.getElementById(
                    'campaignimage1error'); // Error message

                const file = imageInputCampaign1.files[0];

                if (file) {
                    // Cek ukuran file (2MB = 2 * 1024 * 1024)
                    if (file.size >= 2 * 1024 * 1024) {
                        errorMessageCampaign1.textContent =
                            "Ukuran file tidak boleh lebih dari 2MB!"; // Tampilkan pesan errorr
                        errorMessageCampaign1.classList.remove('hidden');
                        previewContainerCampaign1.classList.add('hidden');
                    } else {
                        errorMessageCampaign1.classList.add('hidden'); // Sembunyikan pesan error
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreviewCampaign1.src = e.target.result;
                            previewContainerCampaign1.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }

            // Campaign Image 2
            if (event.target && event.target.id === 'campaign_image2') {
                const imageInputcamp2 = event.target;
                const previewContainercamp2 = document.getElementById('previewContainerImage2');
                const imagePreviewcamp2 = document.getElementById('image2Preview');
                const errorMessagecamp2 = document.getElementById(
                    'campaignimage2error'); // Error message

                const file = imageInputcamp2.files[0];

                if (file) {
                    // Cek ukuran file (2MB = 2 * 1024 * 1024)
                    if (file.size >= 2 * 1024 * 1024) {
                        errorMessagecamp2.textContent =
                            "Ukuran file tidak boleh lebih dari 2MB!"; // Tampilkan pesan errorr
                        errorMessagecamp2.classList.remove('hidden');
                        imageInputcamp2.value = ''; // Reset input file
                        previewContainercamp2.classList.add('hidden');
                    } else {
                        errorMessagecamp2.classList.add('hidden'); // Sembunyikan pesan error
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreviewcamp2.src = e.target.result;
                            previewContainercamp2.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }

            // Campaign Image 3
            if (event.target && event.target.id === 'campaign_image3') {
                const imageInputcampp3 = event.target;
                const previewContainercampp3 = document.getElementById('previewContainerImage3');
                const imagePreviewcampp3 = document.getElementById('image3Preview');
                const errorMessagecamp3 = document.getElementById(
                    'campaignimage3error'); // Error message

                const file = imageInputcampp3.files[0];

                if (file) {
                    // Cek ukuran file (2MB = 2 * 1024 * 1024)
                    if (file.size >= 2 * 1024 * 1024) {
                        errorMessagecamp3.textContent =
                            "Ukuran file tidak boleh lebih dari 2MB!"; // Tampilkan pesan errorr
                        errorMessagecamp3.classList.remove('hidden');
                        imageInputcampp3.value = ''; // Reset input file
                        previewContainercampp3.classList.add('hidden');
                    } else {
                        errorMessagecamp3.classList.add('hidden'); // Sembunyikan pesan error
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreviewcampp3.src = e.target.result;
                            previewContainercampp3.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        // document.addEventListener('change', function(event) {
        //     // Campaign Thumbnail
        //     if (event.target && event.target.id === 'campaign_thumbnail') {
        //         handleFileInput(
        //             event.target,
        //             'previewContainerThumbnail',
        //             'thumbnailPreview',
        //             'thumbnail-error'
        //         );
        //     }

        //     // Campaign Image 1
        //     if (event.target && event.target.id === 'campaign_image1') {
        //         handleFileInput(
        //             event.target,
        //             'previewContainerImage1',
        //             'image1Preview',
        //             'campaignimage1-error'
        //         );
        //     }

        //     // Campaign Image 2
        //     if (event.target && event.target.id === 'campaign_image2') {
        //         handleFileInput(
        //             event.target,
        //             'previewContainerImage2',
        //             'image2Preview',
        //             'campaign_image2-error'
        //         );
        //     }

        //     // Campaign Image 3
        //     if (event.target && event.target.id === 'campaign_image3') {
        //         handleFileInput(
        //             event.target,
        //             'previewContainerImage3',
        //             'image3Preview',
        //             'campaign_image3-error'
        //         );
        //     }
        // });

        // // Fungsi untuk validasi file dan preview
        // function handleFileInput(inputElement, previewContainerId, previewImageId, errorMessageId) {
        //     const previewContainer = document.getElementById(previewContainerId);
        //     const previewImage = document.getElementById(previewImageId);
        //     const errorMessage = document.getElementById(errorMessageId);

        //     const file = inputElement.files[0];

        //     if (file) {
        //         // Validasi ukuran file (maksimum 2MB)
        //         if (file.size >= 2 * 1024 * 1024) {
        //             errorMessage.textContent = "Ukuran file tidak boleh lebih dari 2MB!";
        //             errorMessage.classList.remove('hidden'); // Tampilkan pesan error
        //             inputElement.value = ''; // Reset input file
        //         } else {
        //             errorMessage.classList.add('hidden'); // Sembunyikan pesan error
        //             const reader = new FileReader();
        //             reader.onload = function(e) {
        //                 previewImage.src = e.target.result; // Tampilkan preview gambar baru
        //                 previewContainer.classList.remove('hidden'); // Tampilkan container preview
        //             };
        //             reader.readAsDataURL(file);
        //         }
        //     }
        // }


        document.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'resetButtonThumbnail') {
                const thumbnailInput = document.getElementById('campaign_thumbnail');
                const thumbnailPreview = document.getElementById('thumbnailPreview');
                const previewContainer = document.getElementById('previewContainerThumbnail');
                const errorMessage = document.getElementById('thumbnailerror');

                thumbnailInput.value = ''; // Reset input file
                previewContainer.classList.add('hidden');
                thumbnailPreview.src = ''; // Reset ke gambar lama
                errorMessage.classList.add('hidden'); // Sembunyikan pesan error
            }

            // Reset Button for Image 1
            if (event.target && event.target.id === 'resetButtonImage1') {
                const imageInput = document.getElementById('campaign_image1');
                const previewContainer = document.getElementById('previewContainerImage1');
                const imagePreview = document.getElementById('image1Preview');
                const errorMessage = document.getElementById('campaignimage1error');

                imageInput.value = '';
                previewContainer.classList.add('hidden');
                imagePreview.src = '';
                errorMessage.classList.add('hidden');
            }

            // Reset Button for Campaign Image 2
            if (event.target && event.target.id === 'resetButtonImage2') {
                const imageInput = document.getElementById('campaign_image2');
                const previewContainer = document.getElementById('previewContainerImage2');
                const imagePreview = document.getElementById('image2Preview');
                const errorMessage = document.getElementById('campaignimage2error'); // Error message

                imageInput.value = '';
                previewContainer.classList.add('hidden');
                imagePreview.src = '';
                errorMessage.classList.add('hidden'); // Sembunyikan pesan error
            }

            // Reset Button for Campaign Image 3
            if (event.target && event.target.id === 'resetButtonImage3') {
                const imageInput = document.getElementById('campaign_image3');
                const previewContainer = document.getElementById('previewContainerImage3');
                const imagePreview = document.getElementById('image3Preview');
                const errorMessage = document.getElementById('campaignimage3error'); // Error message

                imageInput.value = '';
                previewContainer.classList.add('hidden');
                imagePreview.src = '';
                errorMessage.classList.add('hidden'); // Sembunyikan pesan error
            }
        });
    });
</script>
