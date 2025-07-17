<main class="flex-1 p-4 md:p-6 bg-gray-100 min-h-screen font-poppins">
  <div class="max-w-6xl mx-auto bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-3xl font-semibold text-slate-700 mb-6">New Service Request</h2>

    <form action="" method="POST" class="space-y-6">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Dropdowns -->
        <div>
          <label for="receptioners_id" class="block text-sm font-medium text-slate-600">Receptioner</label>
          <select id="receptioners_id" name="receptioners_id"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
            <option value="">Select Receptioner</option>
          </select>
        </div>

        <div>
          <label for="technician_id" class="block text-sm font-medium text-slate-600">Technician</label>
          <select id="technician_id" name="technician_id"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
            <option value="">Select Technician</option>
          </select>
        </div>

        <div>
          <label for="service_categories_id" class="block text-sm font-medium text-slate-600">Service Category</label>
          <select id="service_categories_id" name="service_categories_id"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
            <option value="">Select Service Category</option>
          </select>
        </div>

        <div>
          <label for="service_code" class="block text-sm font-medium text-slate-600">Service Code</label>
          <input type="text" id="service_code" name="service_code" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <!-- Text inputs -->
        <div>
          <label for="owner_name" class="block text-sm font-medium text-slate-600">Owner Name</label>
          <input type="text" id="owner_name" name="owner_name" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="product_name" class="block text-sm font-medium text-slate-600">Product Name</label>
          <input type="text" id="product_name" name="product_name" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-slate-600">Email</label>
          <input type="email" id="email" name="email"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="contact" class="block text-sm font-medium text-slate-600">Contact</label>
          <input type="text" id="contact" name="contact" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="brand" class="block text-sm font-medium text-slate-600">Brand</label>
          <input type="text" id="brand" name="brand" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="serial_no" class="block text-sm font-medium text-slate-600">Serial No</label>
          <input type="text" id="serial_no" name="serial_no"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="MAC" class="block text-sm font-medium text-slate-600">MAC Address</label>
          <input type="text" id="MAC" name="MAC"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="color" class="block text-sm font-medium text-slate-600">Color</label>
          <input type="text" id="color" name="color" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="service_amount" class="block text-sm font-medium text-slate-600">Service Amount</label>
          <input type="number" step="0.01" id="service_amount" name="service_amount"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="problem" class="block text-sm font-medium text-slate-600">Problem</label>
          <input type="text" id="problem" name="problem" required
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="remark" class="block text-sm font-medium text-slate-600">Remark</label>
          <input type="text" id="remark" name="remark"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-slate-600">Status</label>
          <input type="number" step="0.01" id="status" name="status" value="0.00"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="last_update" class="block text-sm font-medium text-slate-600">Last Update</label>
          <input type="datetime-local" id="last_update" name="last_update"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="delivered_by" class="block text-sm font-medium text-slate-600">Delivered By</label>
          <input type="text" id="delivered_by" name="delivered_by"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="estimate_delivery" class="block text-sm font-medium text-slate-600">Estimated Delivery</label>
          <input type="datetime-local" id="estimate_delivery" name="estimate_delivery"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>

        <div>
          <label for="date_of_delivery" class="block text-sm font-medium text-slate-600">Date of Delivery</label>
          <input type="datetime-local" id="date_of_delivery" name="date_of_delivery"
            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
        </div>
      </div>

      <div class="pt-4">
        <button type="submit"
          class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200">
          Submit Request
        </button>
      </div>
    </form>
  </div>
</main>
