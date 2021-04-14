<x-public-page :alpine="true" :dontIndex="true">
    <div class="pt-20 px-6 max-w-5xl mx-auto">
        <p class="type-h3 text-gray-600 text-center">Job Application for {{ $post['school_name'] }}</p>
        <x-step-header :step="3" :of="4"></x-step-header>
        <p class="max-w-lg mx-auto my-6">Add your profile picture to let {{ $post['school_name'] }} know who your are. It will gretly increase your chances of landing the job.</p>
    </div>

    <div class="my-12 px-6 max-w-lg mx-auto" x-data="imageUpload()">
        <div x-show="error_message" class="my-4 max-w-md text-center mx-auto p-6 border border-red-500 rounded-lg">
            <p class="type-b4 text-red-500" x-text="error_message"></p>
        </div>
        <div x-show="!error_message && !complete" class="my-4 max-w-md text-center mx-auto p-6 border border-gray-500 rounded-lg">
            <p class="type-b4 text-gray-500">Click on the image below to set your profile image.</p>
        </div>
        <div x-show="!error_message && complete" class="my-4 max-w-md text-center mx-auto p-6 border border-green-500 rounded-lg">
            <p class="type-b4 text-green-500">Your profile image has been set.</p>
        </div>
        <div class="w-80 mx-auto">
            <div
                class="overflow-hidden bg-gray-200"
                @click="chooseFile()"
                @drop.prevent="handleFiles"
                @dragenter.prevent="hovering = true"
                @dragover.prevent="hovering = true"
                @dragleave.prevent="hovering = false"
            >
                <img :src="src" alt="" class="w-full h-full object-cover" :class="{'opacity-50': !complete}" />
            </div>

            <div class="flex justify-between py-2" v-show="!uploading">
                <p class="text-xs">Click image to upload</p>

            </div>
            <input type="file" class="hidden" x-ref="fileInput" @input="processFile($event)" />
        </div>

        <div class="flex flex-col items-center mt-8">
            <form action="/guest-applications/create-application" class="mb-6">
                <button :disabled="!complete" class="btn-main">Next Step &rarr;</button>
            </form>

            <a class="text-gray-600 hover:text-navy" href="/guest-applications/create-application">Skip this step</a>
        </div>


    </div>

    <script>
        function imageUpload() {
            return {
                src: '/images/default_avatar.svg',
                busy: false,
                complete: false,
                error_message: '',
                csrf_token: '{{ csrf_token() }}',

                chooseFile() {
                    this.$refs.fileInput.click();
                },

                processFile({target}) {
                    if (target.files.length) {
                        this.uploadFile(target.files[0]);
                    }
                },

                uploadFile(file) {
                    if(file.type.indexOf('image') !== 0) {
                        return this.error_message = `${file.name} is not a valid image file`;
                    }

                    this.busy = true;
                    this.error_message = '';
                    this.complete = false;

                    this.generatePreview(file);

                    const fd = new FormData();
                    fd.append('image', file);
                    fd.append('_token', this.csrf_token);

                    window.fetch("/guest-applications/profile-image", {method: "POST", body: fd})
                    .then(res => this.handleResponse(res))
                    .catch(() => this.error_message = "There was an problem sending the upload. Please refresh and try again.")
                    .then(() => this.busy = false);
                },

                handleResponse({status, ok}) {
                    if(ok) {
                        return this.complete = true;
                    }
                    if(status === 422) {
                        return this.error_message = "Your file is not valid. Please make sure it is a .jpg or .png, and that it is under 3MB.";
                    }

                    this.error_message = "We were unable to upload your image. Please refresh the page and try again, or try using a different image.";

                },

                generatePreview(file) {
                    const fileReader = new FileReader();
                    fileReader.onload = (ev) => this.src = ev.target.result;
                    // fileReader.onerror = (err) => reject(err);

                    fileReader.readAsDataURL(file);
                }

            };
        }
    </script>



</x-public-page>
