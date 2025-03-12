<!-- resources/views/patient-registration.blade.php -->
@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 max-w-5xl mx-auto">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
                <div class="relative flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-plus text-2xl text-white"></i>
                        <div>
                            <h2 class="text-xl font-semibold text-white">Patient Registration</h2>
                            <p class="text-blue-100 text-sm">Please fill in your information</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form id="patientRegistrationForm" action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Profile Picture Section -->
                    <div class="mb-6">
                        <div class="flex flex-col items-center space-y-4">
                            <div id="camera-container" class="relative w-48 h-48">
                                <div id="camera-preview" class="w-48 h-48 rounded-full bg-gray-200 flex items-center justify-center border-2 border-blue-500 overflow-hidden">
                                    <i class="fas fa-camera text-4xl text-gray-400"></i>
                                </div>
                                <input type="hidden" name="profile_picture" id="profile_picture_input">
                            </div>
                            <div class="flex space-x-4">
                                <button type="button" id="startCamera"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                                    <i class="fas fa-camera mr-2"></i>Take Photo
                                </button>
                                <button type="button" id="capturePhoto"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center"
                                        style="display: none;">
                                    <i class="fas fa-check mr-2"></i>Capture
                                </button>
                                <button type="button" id="retakePhoto"
                                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition flex items-center"
                                        style="display: none;">
                                    <i class="fas fa-redo mr-2"></i>Retake
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" required
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('first_name') }}">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" required
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('last_name') }}">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth" required
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select name="gender" required
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Information -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                <input type="tel" name="contact_information" required
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('contact_information') }}">
                                @error('contact_information')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email_address" required
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('email_address') }}">
                                @error('email_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea name="address" required rows="2"
                                          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Civil Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Civil Status</label>
                                <select name="civil_status" required
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Status</option>
                                    <option value="single" {{ old('civil_status') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('civil_status') == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('civil_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('civil_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                @error('civil_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                <input type="text" name="occupation" required
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('occupation') }}">
                                @error('occupation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Data Privacy Consent Section -->
<div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Privacy Consent</h3>

    <div class="prose prose-sm text-gray-600 mb-4">
        <p>By submitting this form, you acknowledge and agree to the collection and processing of your personal information by our medical facility. We are committed to protecting your privacy and handling your data in accordance with applicable data privacy laws.</p>

        <p class="mt-2">Your information will be used for:</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Medical record keeping and patient care management</li>
            <li>Communication regarding your healthcare services</li>
            <li>Administrative purposes and quality improvement</li>
            <li>Compliance with legal and regulatory requirements</li>
        </ul>

        <p class="mt-2">We ensure that:</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Your data is stored securely and accessed only by authorized personnel</li>
            <li>Your information is not shared with third parties without your consent</li>
            <li>You have the right to access and request corrections to your personal information</li>
        </ul>
    </div>

    <div class="flex items-start mt-4">
        <div class="flex items-center h-5">
            <input id="privacy_consent" name="privacy_consent" type="checkbox" required
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                   {{ old('privacy_consent') ? 'checked' : '' }}>
        </div>
        <label for="privacy_consent" class="ml-3 text-sm">
            <span class="font-medium text-gray-700">I consent to the collection and processing of my personal information</span>
            <span class="text-red-600">*</span>
        </label>
    </div>
    @error('privacy_consent')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="window.location.href='{{ url('/') }}'"
                                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition flex items-center">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let stream = null;
    const cameraPreview = document.getElementById('camera-preview');
    const startButton = document.getElementById('startCamera');
    const captureButton = document.getElementById('capturePhoto');
    const retakeButton = document.getElementById('retakePhoto');

    startButton.addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 480 },
                    height: { ideal: 480 },
                    facingMode: "user"
                }
            });

            const video = document.createElement('video');
            video.srcObject = stream;
            video.autoplay = true;
            video.classList.add('rounded-full', 'w-48', 'h-48', 'object-cover');
            cameraPreview.innerHTML = '';
            cameraPreview.appendChild(video);

            startButton.style.display = 'none';
            captureButton.style.display = 'inline-flex';
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Could not access camera. Please make sure you have granted camera permissions.');
        }
    });

    captureButton.addEventListener('click', () => {
        const video = cameraPreview.querySelector('video');
        const canvas = document.createElement('canvas');
        canvas.width = 480;
        canvas.height = 480;
        const ctx = canvas.getContext('2d');

        // Draw video frame to canvas
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert to base64
        const imageData = canvas.toDataURL('image/jpeg');

        // Create preview image
        const img = document.createElement('img');
        img.src = imageData;
        img.classList.add('rounded-full', 'w-48', 'h-48', 'object-cover');

        // Update preview and form data
        cameraPreview.innerHTML = '';
        cameraPreview.appendChild(img);
        document.getElementById('profile_picture_input').value = imageData;

        // Stop camera stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        // Update buttons
        captureButton.style.display = 'none';
        retakeButton.style.display = 'inline-flex';
    });

    retakeButton.addEventListener('click', () => {
        retakeButton.style.display = 'none';
        startButton.click(); // Restart camera
    });
</script>
@endpush

<style>
.bg-grid-white {
    background-image: linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
                     linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
}
</style>
@endsection
