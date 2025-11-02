<?php

// Wczytanie listy zamówień z osobnego pliku
$plik = __DIR__ . '/zamowienia.php';
if (!file_exists($plik)) {
    die("Nie znaleziono pliku z zamówieniami: $plik");
}
$zamowienia = require $plik;

/**
 * Funkcja obliczająca punkty lojalnościowe PLP.
 * Implementuje wszystkie reguły z dokumentu marketingowego,
 * z uwzględnieniem decyzji projektowej dotyczącej statusu CANCELLED.
 */
function oblicz_punkty_plp(array $lista_zamowien): int {
    $total_plp = 0; 

    foreach ($lista_zamowien as $zamowienie) {
        $punkty = 0;
        $status = strtoupper($zamowienie['status'] ?? '');
        $id = $zamowienie['id'];

        echo "\nPrzetwarzanie zamówienia: {$id}\n";
        echo "Status: {$status}\n";

        // 1. Obsługa przypadków anulowania
        if ($status === 'CANCELLED_BY_USER') {
            echo "Anulowane przez użytkownika – brak punktów.\n";
            echo "Suma punktów po tym zamówieniu: {$total_plp}\n";
            continue;
        } elseif ($status === 'CANCELLED_BY_SYSTEM') {
            if (!empty($zamowienie['klient']['jestVIP'])) {
                $punkty += 50;
                echo "Anulowane przez system – klient VIP, +50 pkt.\n";
            } else {
                echo "Anulowane przez system – klient NIE jest VIP, brak punktów.\n";
            }
            $total_plp += $punkty;
            echo "Suma punktów po tym zamówieniu: {$total_plp}\n";
            continue;
        }

        // 2. Obsługa promocji
        if ($zamowienie['zawieraPromocje'] === true && empty($zamowienie['klient']['jestVIP'])) {
            echo "Zawiera promocje i klient nie jest VIP – brak punktów.\n";
            echo "Suma punktów po tym zamówieniu: {$total_plp}\n";
            continue;
        }

        // 3. Punkty bazowe – 10 pkt za każde pełne 100 zł
        $bazowe_punkty = floor($zamowienie['kwota'] / 100) * 10;
        echo "Bazowe punkty: {$bazowe_punkty}\n";

        // 4. Sprawdzenie daty Black Friday (29 listopada)
        $czy_black_friday = date('m-d', strtotime($zamowienie['data'])) === '11-29';
        if ($czy_black_friday) {
            echo "Black Friday – obowiązuje bonus lub mnożnik VIP.\n";
        }

        // 5. Logika punktowa z uwzględnieniem VIP i Black Friday
        if (!empty($zamowienie['klient']['jestVIP']) && !$czy_black_friday) {
            $punkty += $bazowe_punkty * 2;
            echo "Klient VIP – podwójne punkty ({$punkty}).\n";
        } elseif ($czy_black_friday) {
            if (!empty($zamowienie['klient']['jestVIP'])) {
                $punkty += max($bazowe_punkty * 2, 100);
                echo "VIP w Black Friday – przyznano korzystniejszą wartość: {$punkty} pkt.\n";
            } else {
                $punkty += $bazowe_punkty + 100;
                echo "Zwykły klient w Black Friday – +100 bonus: {$punkty} pkt.\n";
            }
        } else {
            $punkty += $bazowe_punkty;
            echo "Zwykły klient – punkty bazowe: {$punkty} pkt.\n";
        }

        // 6. Aktualizacja łącznej sumy
        $total_plp += $punkty;
        echo "Punkty za to zamówienie: {$punkty}\n";
        echo "Suma punktów po tym zamówieniu: {$total_plp}\n";
    }

    // 7. Podsumowanie końcowe
    echo "\n==============================\n";
    echo "Łączna liczba punktów: {$total_plp}\n";
    echo "==============================\n";

    return $total_plp;
}

// Uruchomienie funkcji
oblicz_punkty_plp($zamowienia);
?>
