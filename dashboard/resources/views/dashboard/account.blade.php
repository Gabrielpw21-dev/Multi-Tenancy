<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha Assinatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 style="font-weight:700;font-size:27px; ">Minha Assinatura</h2>

                    <table style="margin:10px; border:1px solid #CCC;border-radius:10px;">
                        <thead style="margin:15px; border:1px solid #CCC;">
                            <tr style="margin:15px; border:1px solid #CCC;">
                                <th style="padding:8px 14px">Data</th>
                                <th style="padding:8px 14px">Preço</th>
                                <th style="padding:8px 14px">Download</th>
                            </tr>
                        </thead>
                        <tbody style="margin:15px; border:1px solid #CCC;">
                            @foreach ($invoices as $invoice)
                                <tr style="margin:15px; border:1px solid #CCC;">
                                    <td style="padding:8px 14px">{{ $invoice->date()->toFormattedDateString() }}</td>
                                    <td style="padding:8px 14px">{{ $invoice->total() }}</td>
                                    <td style="padding:8px 14px">
                                        <a href="{{ route('dashboard.invoice.download', $invoice->id) }}">Baixar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
