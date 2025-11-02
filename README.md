# Zadanie 5 – Kalkulator Punktów Lojalnościowych (PLP)

**Autor:** Dominik Kowalczyk  
**Technologia:** PHP 8.4  
**Data:** Październik 2025  
**Cel:** Implementacja logiki biznesowej modułu obliczania „Punktów Lojalnościowych Premium (PLP)” dla klientów e-commerce, zgodnie z wymaganiami działu Marketingu.

---

## 1️⃣ Opis funkcjonalny

Moduł oblicza punkty lojalnościowe przyznawane klientom za dokonane zamówienia.  
Punkty są naliczane w zależności od statusu zamówienia, kwoty, obecności produktów promocyjnych, statusu klienta (VIP / zwykły) oraz daty złożenia zamówienia (np. Black Friday).

Projekt uwzględnia wszystkie przekazane reguły biznesowe oraz własną decyzję projektową, mającą na celu zapobieganie nadużyciom punktowym.

---

## 2️⃣ Reguły biznesowe

| Nr  | Reguła                                 | Opis                                                                           |
| --- | -------------------------------------- | ------------------------------------------------------------------------------ |
| 1   | **Bazowa wartość**                     | 10 punktów za każde pełne 100 zł wartości zamówienia                           |
| 2   | **VIP**                                | Klient VIP otrzymuje punkty x2                                                 |
| 3   | **Promocje (non-VIP)**                 | Jeśli zamówienie zawiera produkty promocyjne – brak punktów                    |
| 4   | **Promocje (VIP)**                     | Klient VIP otrzymuje punkty mimo produktów promocyjnych                        |
| 5   | **Black Friday (non-VIP)**             | +100 punktów bonusowych niezależnie od kwoty                                   |
| 6   | **Black Friday (VIP)**                 | Klient VIP otrzymuje **x2 lub +100 pkt** – system wybiera korzystniejszą opcję |
| 7   | **Anulowanie zamówienia (użytkownik)** | `CANCELLED_BY_USER` – brak punktów                                             |
| 8   | **Anulowanie zamówienia (system)**     | `CANCELLED_BY_SYSTEM` – klient VIP otrzymuje 50 pkt, pozostali 0 pkt           |

---

## 3️⃣ Decyzja projektowa

W oryginalnej specyfikacji status `CANCELLED` przyznawał 50 pkt każdemu klientowi VIP.  
Wprowadzone zostało rozróżnienie:

- `CANCELLED_BY_USER` → brak punktów,
- `CANCELLED_BY_SYSTEM` → 50 pkt tylko dla VIP.

> Dzięki temu punkty są przyznawane wyłącznie wtedy, gdy anulowanie wynika z przyczyn niezależnych od klienta (np. błąd systemu lub brak towaru).  
> Rozwiązanie eliminuje możliwość nadużyć (np. anulowania zamówień w celu zdobycia punktów).

---

## 4️⃣ Struktura projektu

```
📦 Zadanie_5_Kalkulator
 ┣ 📜 kalkulator.php     # Główna funkcja obliczeniowa
 ┣ 📜 zamowienia.php     # Dane wejściowe w postaci tablicy asocjacyjnej
 ┗ 📜 README.txt         # Dokumentacja techniczna
```

---

## 5️⃣ Instrukcja uruchomienia

1. **Sprawdź instalację PHP:**
   ```bash
   php -v
   ```
2. **Przejdź do katalogu projektu:**
   ```bash
   cd "C:\Users\sargo\OneDrive\Documents\e-MSI - Zadania rekrutaycjne\Zadanie 5 - Kalkulator"
   ```
3. **Uruchom kalkulator:**
   ```bash
   php kalkulator.php
   ```

---

## 6️⃣ Przykładowe dane wejściowe (`zamowienia.php`)

```php
<?php
return [
  [
    'id' => 'ZAM-001',
    'kwota' => 199.00,
    'status' => 'COMPLETED',
    'data' => '2024-03-15',
    'zawieraPromocje' => false,
    'klient' => ['id' => 'K-001', 'jestVIP' => false]
  ],
  [
    'id' => 'ZAM-002',
    'kwota' => 250.00,
    'status' => 'COMPLETED',
    'data' => '2024-03-15',
    'zawieraPromocje' => false,
    'klient' => ['id' => 'K-002', 'jestVIP' => true]
  ]
];
```

---

## 7️⃣ Wyniki testów

| ID Zamówienia | Status              | VIP | Promocje | Black Friday | Wynik punktowy |
| ------------- | ------------------- | --- | -------- | ------------ | -------------- |
| ZAM-001       | COMPLETED           | ❌  | ❌       | ❌           | 10             |
| ZAM-002       | COMPLETED           | ✅  | ❌       | ❌           | 40             |
| ZAM-003       | COMPLETED           | ❌  | ✅       | ❌           | 0              |
| ZAM-004       | COMPLETED           | ✅  | ✅       | ❌           | 80             |
| ZAM-005       | COMPLETED           | ❌  | ❌       | ✅           | 110            |
| ZAM-006       | COMPLETED           | ✅  | ❌       | ✅           | 100            |
| ZAM-007       | COMPLETED           | ✅  | ❌       | ✅           | 160            |
| ZAM-008       | CANCELLED_BY_USER   | ✅  | ❌       | ❌           | 0              |
| ZAM-009       | CANCELLED_BY_SYSTEM | ✅  | ❌       | ❌           | 50             |
| ZAM-010       | CANCELLED_BY_SYSTEM | ❌  | ❌       | ❌           | 0              |

**Łączna liczba punktów:** 550 ✅

---

## 8️⃣ Wnioski końcowe

- Logika funkcji odzwierciedla wszystkie reguły marketingowe w sposób deterministyczny i testowalny.
- Wprowadzenie rozróżnienia statusów `CANCELLED_BY_USER` i `CANCELLED_BY_SYSTEM` eliminuje ryzyko nadużyć.
- Kod jest modularny, łatwy w utrzymaniu i gotowy do integracji z systemem e-commerce.

---

## 9️⃣ Autor

**Dominik Kowalczyk**  
e-MSI — Zadania rekrutacyjne 2025  
📧 dominik.kowalczyk@example.com
