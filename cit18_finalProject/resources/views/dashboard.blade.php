<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @if(Auth::user()->role !== 'doctor')
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="text-center">
                            <i class="fas fa-calendar-plus text-4xl text-indigo-600 mb-4"></i>
                            <h3 class="text-lg font-semibold mb-2">Book Appointment</h3>
                            <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Schedule Now
                            </a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="text-center">
                            <i class="fas fa-file-medical text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-lg font-semibold mb-2">Appointment History</h3>
                            <button onclick="openAppointmentModal()" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                View History
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Profile Information -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <!-- Display Information -->
                <div id="info-display" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium">{{ Auth::user()->name }}</p>
                        
                        <p class="text-sm text-gray-600 mt-4">Email</p>
                        <p class="font-medium">{{ Auth::user()->email }}</p>

                        <p class="text-sm text-gray-600 mt-4">Role</p>
                        <p class="font-medium capitalize">{{ Auth::user()->role }}</p>

                        <p class="text-sm text-gray-600 mt-4">Gender</p>
                        <p class="font-medium capitalize">{{ Auth::user()->gender ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium">{{ Auth::user()->contact ?? 'Not set' }}</p>
                        
                        <p class="text-sm text-gray-600 mt-4">Date of Birth</p>
                        <p class="font-medium">{{ Auth::user()->date_of_birth ?? 'Not set' }}</p>

                        <p class="text-sm text-gray-600 mt-4">Address</p>
                        <p class="font-medium">{{ Auth::user()->address ?? 'Not set' }}</p>

                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="mt-6">
                    <button onclick="toggleEditForm()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Edit Profile
                    </button>
                </div>

                <!-- Edit Form -->
                <div id="edit-form" class="hidden mt-6">
                    <form action="{{ route('user.update-profile') }}" method="POST">
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
                                <input type="text" name="contact" value="{{ Auth::user()->contact }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ Auth::user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ Auth::user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ Auth::user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ Auth::user()->address }}</textarea>
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

            <!-- Upcoming Appointments -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Upcoming Appointments</h3>
                </div>
                
                <div class="overflow-y-auto max-h-[400px]">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Patient</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Doctor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($upcomingAppointments as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $appointment->appointment_datetime->format('M d, Y h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $appointment->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            Dr. {{ $appointment->doctor->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap capitalize">
                                            {{ $appointment->type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            @if($appointment->status !== 'cancelled' && $appointment->status !== 'confirmed')
                                                @if(Auth::user()->role === 'doctor')
                                                    @if($appointment->status === 'pending' && $appointment->doctor_id === Auth::id())
                                                        <button onclick="approveAppointment({{ $appointment->id }})" 
                                                            class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded-md">
                                                            Approve
                                                        </button>
                                                        <button onclick="cancelAppointment({{ $appointment->id }})" 
                                                            class="text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-md">
                                                            Cancel
                                                        </button>
                                                    @endif
                                                @else
                                                    @if($appointment->user_id === auth()->id())
                                                        <button onclick="rescheduleAppointment({{ $appointment->id }})" 
                                                            class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 px-3 py-1 rounded-md">
                                                            Reschedule
                                                        </button>
                                                        <button onclick="cancelAppointment({{ $appointment->id }})" 
                                                            class="text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-md">
                                                            Cancel
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No appointments found
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

    <!-- Appointment History Modal -->
    <div id="appointment-modal" 
         class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Appointment History</h3>
                <button onclick="closeAppointmentModal()" 
                        class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments ?? [] as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $appointment->appointment_datetime->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Dr. {{ $appointment->doctor->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                           'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->notes ?? 'No notes available' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No appointments found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cancellation Confirmation Modal -->
    <div id="cancel-modal" 
         class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Cancel Appointment</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to cancel this appointment? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-cancel" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Confirm Cancel
                    </button>
                    <button onclick="closeCancelModal()" 
                            class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        No, Keep it
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="error-modal" 
         class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4" id="error-modal-title">Error</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="error-modal-message"></p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="error-modal-close" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this confirmation modal HTML alongside your error modal -->
    <div id="confirm-modal" 
         class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirm Approval</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to approve this appointment?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-approve" 
                            class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mr-2">
                        Approve
                    </button>
                    <button onclick="closeConfirmModal()" 
                            class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEditForm() {
            const infoDisplay = document.getElementById('info-display');
            const editForm = document.getElementById('edit-form');
            const editButton = document.querySelector('button[onclick="toggleEditForm()"]');

            if (editForm.classList.contains('hidden')) {
                infoDisplay.classList.add('hidden');
                editForm.classList.remove('hidden');
                editButton.classList.add('hidden');
            } else {
                infoDisplay.classList.remove('hidden');
                editForm.classList.add('hidden');
                editButton.classList.remove('hidden');
            }
        }

        function openAppointmentModal() {
            document.getElementById('appointment-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAppointmentModal() {
            document.getElementById('appointment-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('appointment-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAppointmentModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAppointmentModal();
            }
        });

        function rescheduleAppointment(appointmentId) {
            window.location.href = `/appointments/${appointmentId}/reschedule`;
        }

        let appointmentToCancel = null;

        function cancelAppointment(appointmentId) {
            appointmentToCancel = appointmentId;
            document.getElementById('cancel-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            document.getElementById('cancel-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            appointmentToCancel = null;
        }

        document.getElementById('confirm-cancel').addEventListener('click', function() {
            if (appointmentToCancel) {
                fetch(`/appointments/${appointmentToCancel}/cancel`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Toastify({
                            text: data.message,
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#10B981",
                            stopOnFocus: true,
                        }).showToast();
                        
                        window.location.reload();
                    } else {
                        showErrorModal(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorModal('An error occurred while cancelling the appointment.');
                });
            }
            closeCancelModal();
        });

        document.getElementById('cancel-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCancelModal();
            }
        });

        function showErrorModal(message) {
            document.getElementById('error-modal-message').textContent = message;
            document.getElementById('error-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeErrorModal() {
            document.getElementById('error-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('error-modal-close').addEventListener('click', closeErrorModal);

        document.getElementById('error-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeErrorModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeErrorModal();
            }
        });

        let appointmentToApprove = null;

        function showConfirmModal(appointmentId) {
            appointmentToApprove = appointmentId;
            document.getElementById('confirm-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            appointmentToApprove = null;
        }

        document.getElementById('confirm-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeConfirmModal();
            }
        });

        document.getElementById('confirm-approve').addEventListener('click', function() {
            if (appointmentToApprove) {
                processApproval(appointmentToApprove);
            }
            closeConfirmModal();
        });

        function approveAppointment(appointmentId) {
            showConfirmModal(appointmentId);
        }

        function processApproval(appointmentId) {
            fetch(`/appointments/${appointmentId}/approve`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#10B981",
                        stopOnFocus: true,
                    }).showToast();
                    
                    window.location.reload();
                } else {
                    showErrorModal(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorModal("An error occurred while approving the appointment");
            });
        }
    </script>

    @if (session('success') || session('error'))
        <script>
            Toastify({
                text: "{{ session('success') ?? session('error') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "{{ session('success') ? '#10B981' : '#EF4444' }}",
                stopOnFocus: true,
                onClick: function(){}
            }).showToast();
        </script>
    @endif
</x-app-layout>
