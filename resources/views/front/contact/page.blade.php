<x-public-page title="Contact ELT Search">
    <div class="my-20 px-6">
        <h1 class="type-h2 text-center text-navy">Contact Us</h1>
        <p class="max-w-xl mx-auto text-center my-6">Please contact us with any questions you may have.</p>
    </div>
    <form x-data="contactForm()"
          x-cloak
          @submit.prevent="submit"
          action="/contact"
          method="POST"
          class="mx-auto max-w-lg mb-20 px-6">
        {!! csrf_field() !!}

        <div class="my-6" :class="{'border-b border-red-500': formErrors.name !== ''}">
            <label class="">
                <span class="form-label">Name</span>
                <span class="text-xs text-red-400"
                      x-text="formErrors.name"
                      x-show="formErrors.name"></span>

                <input
                    name="name"
                    type="text"
                    class="form-text-input"
                    x-model="formData.name"
                />
            </label>
        </div>

        <div class="my-6" :class="{'border-b border-red-500': formErrors.email !== ''}">
            <label class="">
                <span class="form-label">Email</span>
                <span class="text-xs text-red-400"
                      x-text="formErrors.email"
                      x-show="formErrors.email"></span>

                <input
                    name="email"
                    type="email"
                    class="form-text-input"
                    x-model="formData.email"
                />
            </label>
        </div>

        <div class="my-6" :class="{'border-b border-red-500': formErrors.message !== ''}">
            <label class="">
                <span class="form-label">Your message</span>
                <span class="text-xs text-red-400"
                      x-text="formErrors.message"
                      x-show="formErrors.message"></span>
                <textarea name="message" class="form-text-input h-32" x-model="formData.message"
                ></textarea>
            </label>
        </div>


        <div class="flex justify-center my-6">
            <x-waiting-button text="Send Message"></x-waiting-button>
        </div>


        <div class="fixed inset-0 flex justify-center items-center bg-gray-700 bg-opacity-25 px-6" x-show="dialog">
            <div class="max-w-lg w-full bg-white shadow-lg rounded-lg p-6" x-show="success">
                <p class="type-h4 text-navy mb-6">Thank you!</p>
                <p>Your message has been received, and we will respond accordingly.</p>
                <div class="mt-6 flex justify-end">
                    <button type="button" class="btn-main" @click="dialog = false">Okay</button>
                </div>
            </div>
            <div class="max-w-lg w-full bg-white shadow-lg rounded-lg p-6" x-show="!success">
                <p class="type-h4 text-red-600 mb-6">Oh dear!</p>
                <p>There was a problem sending your message. Please refresh the page and try again.</p>
                <div class="mt-6 flex justify-end">
                    <button type="button" class="" @click="dialog = false">Okay</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        function contactForm() {
            return {
                waiting: false,
                dialog: false,
                success: false,
                formData: {
                    name: '',
                    email: '',
                    message: '',
                },
                formErrors: {
                    name: '',
                    email: '',
                    message: '',
                },

                submit() {
                    this.waiting = true;
                    this.clearErrors();

                    fetch("/contact", {
                        method: "POST",
                        headers: {
                            'Accept': 'application/json',
                        },
                        body: new FormData(this.$el),
                    })
                        .then(response => {
                            if(response.ok) {
                                return this.onSuccess();
                            }

                            if(response.status === 422) {
                                return response.json().then((data) => this.onInvalid(data.errors));
                            }

                            this.onError();
                        })
                        .catch(() => {
                            this.onError();
                        }).then(() => this.waiting = false);
                },
                onSuccess() {
                    this.clearForm();
                    this.success = true;
                    this.dialog = true;
                },
                onInvalid({name, email, message}) {
                    this.formErrors.name = name;
                    this.formErrors.email = email;
                    this.formErrors.message = message;
                },
                clearErrors() {
                    this.formErrors.name = '';
                    this.formErrors.email = '';
                    this.formErrors.message = '';
                },
                clearForm() {
                    this.formData.name = '';
                    this.formData.email = '';
                    this.formData.message = '';
                },
                onError() {
                    this.success = false;
                    this.dialog = true;
                }
            }
        }
    </script>
</x-public-page>
