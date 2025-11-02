<?php
return [
    // Zwykły klient, zwykłe zamówienie
    [
        'id' => 'ZAM-001',
        'kwota' => 199.00,
        'status' => 'COMPLETED',
        'data' => '2024-03-15',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-001', 'jestVIP' => false]
    ],
    // VIP – zwykłe zamówienie (test mnożnika x2)
    [
        'id' => 'ZAM-002',
        'kwota' => 250.00,
        'status' => 'COMPLETED',
        'data' => '2024-03-15',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-002', 'jestVIP' => true]
    ],
    // Zwykły klient – zamówienie z promocją (brak punktów)
    [
        'id' => 'ZAM-003',
        'kwota' => 350.00,
        'status' => 'COMPLETED',
        'data' => '2024-04-02',
        'zawieraPromocje' => true,
        'klient' => ['id' => 'K-003', 'jestVIP' => false]
    ],
    // VIP – zamówienie z promocją (VIP dostaje punkty mimo promocji)
    [
        'id' => 'ZAM-004',
        'kwota' => 420.00,
        'status' => 'COMPLETED',
        'data' => '2024-04-02',
        'zawieraPromocje' => true,
        'klient' => ['id' => 'K-004', 'jestVIP' => true]
    ],
    // Zwykły klient – Black Friday (bonus 100 pkt)
    [
        'id' => 'ZAM-005',
        'kwota' => 180.00,
        'status' => 'COMPLETED',
        'data' => '2024-11-29', // Black Friday
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-005', 'jestVIP' => false]
    ],
    // VIP – Black Friday (porównanie 100 pkt vs x2)
    [
        'id' => 'ZAM-006',
        'kwota' => 345.50, // 30 pkt x2 = 60 → mniej niż 100
        'status' => 'COMPLETED',
        'data' => '2024-11-29',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-006', 'jestVIP' => true]
    ],
    // VIP – Black Friday, duże zamówienie (x2 korzystniejsze)
    [
        'id' => 'ZAM-007',
        'kwota' => 800.00, // 80 pkt x2 = 160 → więcej niż 100
        'status' => 'COMPLETED',
        'data' => '2024-11-29',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-007', 'jestVIP' => true]
    ],
    // Zamówienie anulowane przez użytkownika (CANCELLED_BY_USER)
    [
        'id' => 'ZAM-008',
        'kwota' => 500.00,
        'status' => 'CANCELLED_BY_USER',
        'data' => '2024-07-01',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-008', 'jestVIP' => true]
    ],
    // Zamówienie anulowane przez system – klient VIP (50 pkt)
    [
        'id' => 'ZAM-009',
        'kwota' => 500.00,
        'status' => 'CANCELLED_BY_SYSTEM',
        'data' => '2024-07-01',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-009', 'jestVIP' => true]
    ],
    //  Zamówienie anulowane przez system – klient NIE jest VIP (0 pkt)
    [
        'id' => 'ZAM-010',
        'kwota' => 500.00,
        'status' => 'CANCELLED_BY_SYSTEM',
        'data' => '2024-07-01',
        'zawieraPromocje' => false,
        'klient' => ['id' => 'K-010', 'jestVIP' => false]
    ]
];
?>