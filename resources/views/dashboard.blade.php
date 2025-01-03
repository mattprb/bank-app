<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Twoje konto bankowe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($account)
                        <h3 class="text-2xl font-semibold">Saldo: {{ number_format($account->balance, 2) }} PLN</h3>
                    @else
                        <p>Nie masz jeszcze konta bankowego. Skontaktuj się z administratorem.</p>
                    @endif

                    <!-- Komunikat o powodzeniu -->
                    @if (session('success'))
                        <div class="mt-4 p-4 bg-green-500 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Form for transfer -->
                    <form method="POST" action="{{ route('account.transfer') }}">
                        @csrf
                        <div class="mt-4">
                            <label for="recipient_account_id">Numer konta odbiorcy:</label>
                            <input type="text" name="recipient_account_id" required
                                class="border-gray-300 rounded-md shadow-sm mt-2 w-full">
                        </div>

                        <div class="mt-4">
                            <label for="amount">Kwota przelewu:</label>
                            <input type="number" name="amount" min="1" required
                                class="border-gray-300 rounded-md shadow-sm mt-2 w-full">
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-opacity-75">
                                Przelej
                            </button>
                        </div>
                    </form>

                    @if (session('errors'))
                        <div class="mt-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
