<?php defined( 'ABSPATH' ) || exit; ?>
<?php $text_domain = \Inspire_Labs\Posadzimy\App::TEXTDOMAIN ?>
<style>.woocommerce-save-button {
		display: none !important;
	}</style>
<h1><?php _e( 'Instrukcja integracji z Posadzimy.pl', 'posadzimy' ) ?></h1>

<p><?php _e( 'Przejdź na stronę', $text_domain ) ?> <a href="https://panel.posadzimy.pl/rejestracja">https://panel.posadzimy.pl/rejestracja</a> <?php _e( 'i zarejestruj się uzupełniając odpowiednie pola. Jeśli jesteś zarejestrowany przejdź do logowania.',
			$text_domain ) ?></p>

<h3><?php _e( 'Logowanie i włączenie sadzenia przez API', $text_domain ) ?></h3>

<p><?php _e( 'Po prawidłowej rejestracji, zostaniesz automatycznie zalogowany i przekierowany na panel klienta.',
			$text_domain ) ?></p>

<p><?php _e( 'Przejdź do “Sadzenie przez API”, klikając w link znajdujący się po w menu po lewej stronie ekranu.',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/1.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/1.jpg">
</a>

<p><?php _e( 'Uruchom sadzenie przez API, kliknąć niebieski przycisk “Uruchom”', $text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/2.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/2.jpg">
</a>

<p><?php _e( 'Podaj dane swojej firmy i potwierdź przyciskiem “Uruchom”', $text_domain ) ?></p>

<a href="https://static.posadzimy.pl/integrations/woocommerce/3.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/3.jpg">
</a>

<h3><?php _e( 'Dodanie sadzenia przez API', $text_domain ) ?></h3>

<p><?php _e( 'Przejdź do “Lista posadzeń” używająć menu z lewej strony.', $text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/4.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/4.jpg">
</a>

<p><?php _e( 'Wybierz zakładkę “Lista sadzeń przez API”, a następnie kliknij w utwórz nowe sadzenie',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/5.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/5.jpg">
</a>

<p><?php _e( 'Jeśli chcesz, możesz opcjonalnie zmienić nazwę i dodać opis sadzenia. Informacje te będą widoczne tylko w serwisie Posadzimy.pl, na stronie Twojego sklepu.',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/6.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/6.jpg">
</a>

<h3><?php _e( 'Doładowanie kredytów', $text_domain ) ?></h3>

<p><?php _e( 'Po poprawnym utworzeniu sadzenia, wracamy do "Sadzenie przez API", klikając w menu po lewej stronie ekranu.',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/7.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/7.jpg">
</a>

<p><?php _e( 'Aby automatycznie sadzić drzewo, generować i wysyłać certyfikat do klientów Twojego sklepu, musisz doładować swoje konto w Posadzimy.pl. Koszt jednego drzewa to 9.90 zł netto.',
			$text_domain ) ?></p>

<p><?php _e( 'Aby doładować konto, wybierz liczbę kredytów. Następnie wybierz formę płatności.
	W przypadku PayU płatność zostanie zaksięgowana automatycznie i kredyty od razu dodane do Twojego konta. Jeśli wybierzesz zapłatę przelewem, otrzymasz fakturę pro forma a po zaksięgowaniu wpłaty kredyty zostaną dodane do Twojego konta.
	W obu przypadkach po zaksięgowaniu wpłaty otrzymasz fakturę VAT.', $text_domain ) ?>
</p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/8.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/8.jpg">
</a>

<h3><?php _e( 'Integracja z Twoim sklepem', $text_domain ) ?></h3>

<p><?php _e( 'W opcjach wtyczki w panelu WooCommerce, przejdź do zakładki “Ustawienia ogólne”', $text_domain ) ?></p>

<p><?php _e( 'Podaj minimalną wartość zamówienia brutto (bez wysyłki), dla którego generowane będzie drzewo i wysyłany do klienta sklepu certyfikat.',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/9.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/9.jpg">
</a>

<p><?php _e( 'Następnie musisz poprawnie podać dwa ciągi znaków :', $text_domain ) ?></p>
<p><?php _e( 'Klucz API oraz ID Sadzenia.', $text_domain ) ?></p>
<p><?php _e( 'Obie dane znajdziesz w panelu Posadzimy.pl, w zakładce “Sadzenie przez API”', $text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/10.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/10.jpg">
</a>
<p><?php _e( 'Po podaniu tych danych, przejdź na sam dół strony ustawień i kliknij przycisk “Zapisz zmiany”',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/11.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/11.jpg">
</a>

<p><?php _e( 'W przypadku podania prawidłowych danych do integracji, otrzymasz informacje o liczbie posiadanych kredytów, widoczną w nagłówku zakładki “Posadzimy.pl”',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/12.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/12.jpg">
</a>

<h1><?php _e( 'Ustawienia w sklepie woocommerce', $text_domain ) ?></h1>
<h3><?php _e( 'Tekst na certyfikacie', $text_domain ) ?></h3>

<p><?php _e( 'Po posadzeniu drzewa, generowany jest certyfikat, który wysyłany jest do klienta sklepu. W tym ustawieniu, możemy opcjonalnie dodać krótki text, który pokazywać się będzie na certyfikacie dla klientów:',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/13.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/13.jpg">
</a>

<h3><?php _e( 'Powiadomienia systemowe w sklepie', $text_domain ) ?></h3>

<p><?php _e( 'Wtyczka może automatycznie dodać edytowalne powiadomienia o sadzeniu drzew. Możemy ustalić wiadomość przed osiągnięciem minimalnego progu oraz po osiągnięciu minimalnego progu. W przypadku powiadomienia przed osiągnięciem progu, may do dyspozycji dwie zmienne: {{wysokosc_zamowienia}} i {{brakujaca_kwota}}',
			$text_domain ) ?></p>

<p><?php _e( 'Każde z trzech powiadomień można osobno włączyć / wyłączyć. Powiadomienia nie będą wyświetlane, jeśli w połączonym koncie w Posadzimy.pl nie ma kredytów.',
			$text_domain ) ?></p>

<p><?php _e( 'Miejsca możliwych powiadomień:', $text_domain ) ?></p>

<ul>
	<li>
		<p><?php _e( 'Na stronie produktu', $text_domain ) ?></p>
		<a href="https://static.posadzimy.pl/integrations/woocommerce/powiadomienie-produkt.jpg" class="glightbox">
			<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/powiadomienie-produkt.jpg">
		</a>
	</li>
	<li>
		<p><?php _e( 'Na stronie koszyka, ponad tabelą z produktami', $text_domain ) ?></p>
		<a href="https://static.posadzimy.pl/integrations/woocommerce/powiadomienie-koszyk.jpg" class="glightbox">
			<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/powiadomienie-koszyk.jpg">
		</a>
	</li>
	<li>
		<p><?php _e( 'Na stronie podsumowania zamówienia', $text_domain ) ?></p>
		<a href="https://static.posadzimy.pl/integrations/woocommerce/powiadomienie-checkout.jpg" class="glightbox">
			<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/powiadomienie-checkout.jpg">
		</a>
	</li>
</ul>


<h1><?php _e( 'Wysyłka maili z certyfikatem posadzenia', $text_domain ) ?></h1>

<p><?php _e( 'Po zmianie przez sklep statusu zamówienia na “zrealizowane”, mamy do dyspozycji dwie opcje wysłania certyfikatu do klienta sklepu',
			$text_domain ) ?></p>

<h3><?php _e( 'Wysyłka przez sklep osobnej wiadomości e-maila z informacją o posadzeniu linkiem do certyfikatu, po zaksięgowaniu wpłaty',
			$text_domain ) ?></h3>

<p><?php _e( 'W tym przypadku, mail wysyłany jest przez serwer sklepu, na adres mailowy podany w zamówieniu. ',
			$text_domain ) ?></p>

<p><?php _e( 'Temat wiadomości ustalany jest w opcjach wtyczki przez sklep.', $text_domain ) ?></p>

<p><?php _e( 'Wysyłany jest szablon mailowy Posadzimy.pl, z możliwością edycji część maila, umieszczając tam np. Podziękowanie za zakup. Widok przykładowego maila”',
			$text_domain ) ?></p>

<a href="https://static.posadzimy.pl/integrations/woocommerce/17.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/17.jpg">
</a>

<h3><?php _e( 'Dodanie sekcji z informacją o posadzeniu i certyfikacie do maila wysyłanego przez WooCommerce, po zaksięgowaniu wpłaty',
			$text_domain ) ?></h3>
<p><?php _e( 'W przypadku tej opcji, do maila systemowego z WooCommerce, dodawana jest sekcja z certyfikatem. W opcjach wtyczki można ustawić tekst jaki ma się pojawić w tej sekcji. Po tym tekście wklejany jest automatycznie link do certyfikatu.',
			$text_domain ) ?></p>
<a href="https://static.posadzimy.pl/integrations/woocommerce/18.jpg" class="glightbox">
	<img class="posadzimy-mini-img" src="https://static.posadzimy.pl/integrations/woocommerce/mini/18.jpg">
</a>

<h1><?php _e( 'Kontakt', $text_domain ) ?></h1>
<p><?php _e( 'W razie problemów z integracją, zapraszamy do kontaktu mailowego na adres: kontakt@posadzimy.pl',
			$text_domain ) ?></p>
