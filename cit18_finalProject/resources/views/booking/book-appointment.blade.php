<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ isset($appointment) ? __('Reschedule Appointment') : __('Book Appointment') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <form action="{{ isset($appointment) ? route('appointments.update', $appointment->id) : route('appointments.store') }}" 
                    method="POST">
                  @csrf
                  @if(isset($appointment))
                      @method('PUT')
                  @endif

                  <!-- Doctor Selection -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                      @if(isset($appointment))
                          <input type="text" 
                                 value="Dr. {{ $appointment->doctor->name }}" 
                                 class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" 
                                 disabled>
                          <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                      @else
                          <select name="doctor_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                              <option value="">Choose a doctor</option>
                              @foreach($doctors as $doctor)
                                  <option value="{{ $doctor->id }}">
                                      Dr. {{ $doctor->name }} - {{ $doctor->specialization }}
                                  </option>
                              @endforeach
                          </select>
                      @endif
                  </div>

                  <!-- Appointment Date -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date and Time</label>
                      <input type="datetime-local" 
                             name="appointment_datetime" 
                             min="{{ date('Y-m-d\TH:i') }}"
                             value="{{ isset($appointment) ? $appointment->appointment_datetime->format('Y-m-d\TH:i') : '' }}"
                             required
                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                  </div>

                  <!-- Appointment Type -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                      @if(isset($appointment))
                          <input type="text" 
                                 value="{{ ucfirst($appointment->type) }}" 
                                 class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" 
                                 disabled>
                          <input type="hidden" name="type" value="{{ $appointment->type }}">
                      @else
                          <select name="type" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                              <option value="">Select type</option>
                              <option value="consultation">Consultation</option>
                              <option value="follow_up">Follow-up</option>
                              <option value="check_up">Regular Check-up</option>
                              <option value="emergency">Emergency</option>
                          </select>
                      @endif
                  </div>

                  <!-- Reason -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                      @if(isset($appointment))
                          <input type="text" 
                                 value="{{ $appointment->reason }}" 
                                 class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" 
                                 disabled>
                          <input type="hidden" name="reason" value="{{ $appointment->reason }}">
                      @else
                          <textarea name="reason" required 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Please describe your symptoms or reason for visit"></textarea>
                      @endif
                  </div>

                  <!-- Additional Notes -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                      <textarea name="notes" rows="2" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Any additional information you'd like to share">{{ old('notes') }}</textarea>
                  </div>

                  <!-- Submit Buttons -->
                  <div class="flex justify-end space-x-2">
                      <a href="{{ route('dashboard') }}" 
                          class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                          Cancel
                      </a>
                      <button type="submit" 
                          class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                          {{ isset($appointment) ? 'Update Appointment' : 'Book Appointment' }}
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</x-app-layout>