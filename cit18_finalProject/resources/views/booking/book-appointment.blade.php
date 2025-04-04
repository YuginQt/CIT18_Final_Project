<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Book Appointment') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
              <form action="{{ route('appointments.store') }}" method="POST">
                  @csrf
                  
                  <!-- Doctor Selection -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Select Doctor</label>
                      <select name="doctor_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                          <option value="">Choose a doctor</option>
                          @foreach($doctors as $doctor)
                              <option value="{{ $doctor->id }}">
                                  Dr. {{ $doctor->name }} - {{ $doctor->specialization }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Appointment Date -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                      <input type="date" name="appointment_date" 
                          min="{{ date('Y-m-d') }}"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                  </div>

                  <!-- Appointment Time -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                      <select name="appointment_time" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                          <option value="">Select time</option>
                          <option value="09:00">9:00 AM</option>
                          <option value="10:00">10:00 AM</option>
                          <option value="11:00">11:00 AM</option>
                          <option value="14:00">2:00 PM</option>
                          <option value="15:00">3:00 PM</option>
                          <option value="16:00">4:00 PM</option>
                      </select>
                  </div>

                  <!-- Appointment Type -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Type</label>
                      <select name="appointment_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                          <option value="">Select type</option>
                          <option value="consultation">Consultation</option>
                          <option value="follow_up">Follow-up</option>
                          <option value="check_up">Regular Check-up</option>
                          <option value="emergency">Emergency</option>
                      </select>
                  </div>

                  <!-- Reason for Visit -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                      <textarea name="reason" rows="3" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Please describe your symptoms or reason for visit"></textarea>
                  </div>

                  <!-- Additional Notes -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                      <textarea name="notes" rows="2" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Any additional information you'd like to share"></textarea>
                  </div>

                  <!-- Error Messages -->
                  @if ($errors->any())
                      <div class="mb-6">
                          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                              <ul class="list-disc list-inside">
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      </div>
                  @endif

                  <!-- Submit Buttons -->
                  <div class="flex justify-end space-x-2">
                      <a href="{{ route('dashboard') }}" 
                          class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                          Cancel
                      </a>
                      <button type="submit" 
                          class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                          Book Appointment
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</x-app-layout>