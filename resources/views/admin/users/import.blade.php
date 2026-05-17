<x-app-layout>

    <div class="max-w-2xl mx-auto py-10">

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h2 class="text-2xl font-black text-[#0b3c70] mb-2">
                Import Data Pegawai
            </h2>

            <p class="text-slate-500 mb-6">
                Upload file Excel untuk menambahkan banyak user sekaligus.
            </p>

            <form action="{{ route('admin.users.import') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <input type="file"
                    name="file"
                    class="w-full border rounded-2xl p-4 mb-6">

                <button type="submit"
                    class="px-6 py-3 rounded-2xl bg-[#0b3c70] text-white font-bold">
                    Import Excel
                </button>

            </form>

        </div>

    </div>

</x-app-layout>