<main class="flex-1 p-4 md:p-6 overflow-auto">
    <h2 class="text-2xl font-bold mb-6">New Service Request</h2>
    <form action="" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="receptioners_id"
                    class="block text-sm font-medium text-gray-700">Receptioner</label>
                <select id="receptioners_id" name="receptioners_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    <option value="">Select Receptioner</option>
                    <!-- Populate with receptioners -->
                </select>
            </div>
            <div>
                <label for="technician_id"
                    class="block text-sm font-medium text-gray-700">Technician</label>
                <select id="technician_id" name="technician_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    <option value="">Select Technician</option>
                    <!-- Populate with technicians -->
                </select>
            </div>
            <div>
                <label for="service_categories_id" class="block text-sm font-medium text-gray-700">Service
                    Category</label>
                <select id="service_categories_id" name="service_categories_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    <option value="">Select Service Category</option>
                    <!-- Populate with service categories -->
                </select>
            </div>
            <div>
                <label for="service_code" class="block text-sm font-medium text-gray-700">Service
                    Code</label>
                <input type="text" id="service_code" name="service_code"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                <input type="text" id="owner_name" name="owner_name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="product_name" class="block text-sm font-medium text-gray-700">Product
                    Name</label>
                <input type="text" id="product_name" name="product_name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                <input type="text" id="contact" name="contact"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <input type="text" id="brand" name="brand"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="serial_no" class="block text-sm font-medium text-gray-700">Serial No</label>
                <input type="text" id="serial_no" name="serial_no"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="MAC" class="block text-sm font-medium text-gray-700">MAC Address</label>
                <input type="text" id="MAC" name="MAC"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                <input type="text" id="color" name="color"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="service_amount" class="block text-sm font-medium text-gray-700">Service
                    Amount</label>
                <input type="number" step="0.01" id="service_amount" name="service_amount"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="problem" class="block text-sm font-medium text-gray-700">Problem</label>
                <input type="text" id="problem" name="problem"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
                    required>
            </div>
            <div>
                <label for="remark" class="block text-sm font-medium text-gray-700">Remark</label>
                <input type="text" id="remark" name="remark"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="number" step="0.01" id="status" name="status" value="0.00"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="last_update" class="block text-sm font-medium text-gray-700">Last
                    Update</label>
                <input type="datetime-local" id="last_update" name="last_update"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="delivered_by" class="block text-sm font-medium text-gray-700">Delivered
                    By</label>
                <input type="text" id="delivered_by" name="delivered_by"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="estimate_delivery" class="block text-sm font-medium text-gray-700">Estimated
                    Delivery</label>
                <input type="datetime-local" id="estimate_delivery" name="estimate_delivery"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label for="date_of_delivery" class="block text-sm font-medium text-gray-700">Date of
                    Delivery</label>
                <input type="datetime-local" id="date_of_delivery" name="date_of_delivery"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            </div>
        </div>
        <div class="mt-6">
            <button type="submit"
                class="w-full bg-primary text-white font-bold py-2 rounded-md hover:bg-blue-700 transition duration-200">Submit
                Request</button>
        </div>
    </form>
</main>
