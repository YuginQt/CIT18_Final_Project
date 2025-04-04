<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Personal Information</h3>
                    <button onclick="toggleEditForm()" class="text-sm text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit mr-1"></i> Edit Profile
                    </button>
                </div>
                
                <!-- Display Information -->
                <div id="info-display" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600 mt-2">Email</p>
                        <p class="font-medium">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium">{{ Auth::user()->patient->contact ?? 'Not set' }}</p>
                        <p class="text-sm text-gray-600 mt-2">Date of Birth</p>
                        <p class="font-medium">{{ Auth::user()->patient->date_of_birth ?? 'Not set' }}</p>
                    </div>
                </div>

                <!-- Edit Form -->
                <div id="edit-form" class="hidden">
                    <form action="{{ route('patient.update-profile') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="contact" value="{{ Auth::user()->patient->contact ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ Auth::user()->patient->date_of_birth ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" onclick="toggleEditForm()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-center">
                        <i class="fas fa-calendar-plus text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-lg font-semibold mb-2">Book Appointment</h3>
                        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Schedule Now
                        </button>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-center">
                        <i class="fas fa-comments text-4xl text-green-600 mb-4"></i>
                        <h3 class="text-lg font-semibold mb-2">Message Doctor</h3>
                        <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Start Chat
                        </button>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-center">
                        <i class="fas fa-file-medical text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-lg font-semibold mb-2">Medical Records</h3>
                        <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            View Records
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Upcoming Appointments</h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">Dec 24, 2023 10:00 AM</td>
                                <td class="px-6 py-4">Dr. Smith</td>
                                <td class="px-6 py-4">Check-up</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                    <button class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        Reschedule
                                    </button>
                                    <button class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Recent Medical Records</h3>
                    <div class="space-x-2">
                        <button class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-download mr-1"></i> Download
                        </button>
                        <button class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Recent Diagnoses</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-file-medical text-gray-400 mr-2"></i>
                                <span>Diagnosis 1 - Date</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Current Medications</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-pills text-gray-400 mr-2"></i>
                                <span>Medication 1 - Dosage</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Recent Lab Results</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-flask text-gray-400 mr-2"></i>
                                <span>Lab Test 1 - Date</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Treatment History</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-procedures text-gray-400 mr-2"></i>
                                <span>Treatment 1 - Date</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Add this script at the bottom of your blade file -->
<script>
function toggleEditForm() {
    const displayDiv = document.getElementById('info-display');
    const editForm = document.getElementById('edit-form');
    
    if (displayDiv.classList.contains('hidden')) {
        displayDiv.classList.remove('hidden');
        editForm.classList.add('hidden');
    } else {
        displayDiv.classList.add('hidden');
        editForm.classList.remove('hidden');
    }
}
</script>
