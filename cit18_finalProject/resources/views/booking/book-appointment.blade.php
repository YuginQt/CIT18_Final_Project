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
                      <select name="doctor_id" required 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('doctor_id') border-red-500 @enderror">
                          <option value="">Choose a doctor</option>
                          @foreach($doctors as $doctor)
                              <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                  Dr. {{ $doctor->name }} - {{ $doctor->specialization }}
                              </option>
                          @endforeach
                      </select>
                      @error('doctor_id')
                          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                      @enderror
                  </div>

                  <!-- Appointment Date and Time (Combined) -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date and Time</label>
                      <input type="datetime-local" 
                          name="appointment_datetime" 
                          min="{{ date('Y-m-d\TH:i') }}"
                          value="{{ old('appointment_datetime') }}"
                          required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('appointment_datetime') border-red-500 @enderror">
                      @error('appointment_datetime')
                          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                      @enderror
                  </div>

                  <!-- Appointment Type -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Type</label>
                      <select name="type" required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('type') border-red-500 @enderror">
                          <option value="">Select type</option>
                          <option value="consultation" {{ old('type') == 'consultation' ? 'selected' : '' }}>Consultation</option>
                          <option value="follow_up" {{ old('type') == 'follow_up' ? 'selected' : '' }}>Follow-up</option>
                          <option value="check_up" {{ old('type') == 'check_up' ? 'selected' : '' }}>Regular Check-up</option>
                          <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                      </select>
                      @error('type')
                          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                      @enderror
                  </div>

                  <!-- Reason for Visit -->
                  <div class="mb-6">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                      <textarea name="reason" rows="3" required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('reason') border-red-500 @enderror"
                          placeholder="Please describe your symptoms or reason for visit">{{ old('reason') }}</textarea>
                      @error('reason')
                          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                      @enderror
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
                          Book Appointment
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</x-app-layout>