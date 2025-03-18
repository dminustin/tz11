@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">История операций</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Поиск по описанию...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="operations-table">
                <thead>
                <tr>
                    <th scope="col">Дата
                        <a href="{{ route('history', array_merge(request()->all(), ['sort' => 'date', 'direction' => 'desc'])) }}">↓</a>
                        <a href="{{ route('history', array_merge(request()->all(), ['sort' => 'date', 'direction' => 'asc'])) }}">↑</a>
                    </th>
                    <th scope="col">Тип</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Описание</th>
                </tr>
                </thead>
                <tbody>
                @foreach($operations as $operation)
                    <tr>
                        <td>{{ $operation->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $operation->type == 'credit' ? 'Начисление' : 'Списание' }}</td>
                        <td>{{ number_format($operation->amount, 2, ',', ' ') }}</td>
                        <td class="description">{{ $operation->description }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $operations->appends(request()->query())->links() }}
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const rows = document.querySelectorAll('#operations-table tbody tr');

            searchInput.addEventListener('input', function () {
                const value = this.value.toLowerCase();
                rows.forEach(row => {
                    const description = row.querySelector('.description').textContent.toLowerCase();
                    row.style.display = description.includes(value) ? '' : 'none';
                });
            });
        });
    </script>


@endsection


