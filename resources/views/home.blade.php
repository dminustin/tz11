@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <h4>Текущий баланс: <span id="user-balance">Загрузка...</span></h4>

                        <hr>

                        <h5>Последние операции</h5>
                        <ul id="latest-operations" class="list-group">
                            <li class="list-group-item">Загрузка...</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            function fetchDashboardData() {
                fetch('{{ route('dashboard.data') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('user-balance').innerText = data.balance.toFixed(2) + ' ₽';

                        const list = document.getElementById('latest-operations');
                        list.innerHTML = '';
                        if (data.operations.length === 0) {
                            list.innerHTML = '<li class="list-group-item">Нет операций</li>';
                        } else {
                            data.operations.forEach(op => {
                                const item = document.createElement('li');
                                item.className = 'list-group-item';
                                item.innerHTML = `<strong>${op.created_at}</strong> — ${op.type === 'credit' ? 'Начисление' : 'Списание'}: ${op.amount} ₽<br>${op.description}`;
                                list.appendChild(item);
                            });
                        }
                    });
            }

            document.addEventListener('DOMContentLoaded', function () {
                fetchDashboardData();

                setInterval(fetchDashboardData, 10000);
            });
        </script>

@endsection
