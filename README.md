# Pulse

Social network ispirato a Instagram, sviluppato con Laravel: feed, profili, follower, momenti (storie temporanee), notifiche e chat privata.

Progetto personale realizzato a scopo di studio e portfolio.

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?logo=alpine.js&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?logo=vite&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)



## Anteprima

| Home | Post e commenti |
|---|---|
| ![Home con feed e momenti](docs/screenshots/home.png) | ![Post con like e commenti](docs/screenshots/commenti.png) |
| **Profilo** | **Esplora persone** |
| ![Profilo utente](docs/screenshots/profilo.png) | ![Esplora e ricerca persone](docs/screenshots/esplora.png) |
| **Chat privata** | **Notifiche** |
| ![Chat privata tra utenti](docs/screenshots/chat.png) | ![Notifiche](docs/screenshots/notifiche.png) |
| **Accesso** | **Registrazione** |
| ![Pagina di accesso](docs/screenshots/login.png) | ![Pagina di registrazione](docs/screenshots/registrazione.png) |

## Funzionalità

- **Account:** registrazione (nome, username, email, password) e accesso con Laravel Breeze.
- **Profili:** foto profilo, bio, località e contatori di follower, seguiti e post. Solo il titolare può modificare il proprio profilo.
- **Esplora:** ricerca delle persone per nome o username.
- **Follow:** seguire e smettere di seguire altri utenti.
- **Home:** feed dei post, dal più recente, con paginazione.
- **Post:** testo (fino a 255 caratteri) con foto opzionale. Ogni utente può eliminare i propri post.
- **Like e commenti:** like ai post e commenti sotto ogni post.
- **Momenti:** immagini temporanee (storie) mostrate per 24 ore dalla pubblicazione.
- **Notifiche:** per i like ai propri post e per i nuovi follower, con contatore delle non lette.
- **Chat privata:** messaggi diretti tra due utenti, con elenco delle conversazioni e contatore dei messaggi non letti.

## Stack tecnologico

| Ambito | Tecnologie |
|---|---|
| Backend | PHP 8.3, Laravel 11 |
| Frontend | Blade, Alpine.js, Tailwind CSS, Vite |
| Database | MySQL |
| Autenticazione | Laravel Breeze |

## Sicurezza

- Autenticazione con Laravel Breeze.
- Controllo di proprietà: solo l'autore può eliminare un post o un momento e solo il titolare può modificare il proprio profilo (altrimenti risposta 403).
- Chat: la conversazione è sempre ricavata dall'utente autenticato, quindi non è possibile leggere i messaggi di altri cambiando l'URL.
- Validazione lato server di testi, immagini (tipo e dimensione massima) e dati del profilo.
- Rate limiting sulla pubblicazione di post e commenti (10 richieste al minuto).
- Header di sicurezza HTTP tramite un middleware dedicato (`SecurityHeaders`): `X-Frame-Options`, `X-Content-Type-Options` e una Content-Security-Policy di base.
- Protezione CSRF di Laravel, escaping dell'output con Blade, query tramite Eloquent (parametri legati) e `$fillable` contro il mass assignment.

## Scelte tecniche

- **Momenti:** ogni momento salva una data di scadenza (`expires_at`, 24 ore dopo la creazione) e la home mostra solo quelli ancora attivi grazie a uno scope di Eloquent (`Moment::active()`).
- **Like:** tabella `likes` (utente e post). La stessa azione aggiunge o rimuove il like e, se il post è di un altro utente, genera la notifica.
- **Notifiche:** sistema di notifiche di Laravel sul canale `database` (`PostLiked`, `UserFollowed`). La pagina Notifiche segna come lette quelle non lette.
- **Follow:** relazione many-to-many tra utenti (`following` e `followers`), gestita con `attach` e `detach`.
- **Chat:** tabella `messages` (mittente, destinatario, testo, stato di lettura). I messaggi ricevuti vengono segnati come letti all'apertura della conversazione. La chat funziona con richieste HTTP classiche, senza WebSocket.

## Installazione in locale

**Requisiti:** PHP 8.3, Composer, Node.js con npm, MySQL.

```bash
git clone https://github.com/DanieleUva/Pulse.git
cd Pulse

composer install
npm install

cp .env.example .env        # su Windows (cmd): copy .env.example .env
php artisan key:generate
```

Crea un database MySQL vuoto, poi apri il file `.env` e imposta `DB_CONNECTION=mysql` insieme a `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`. Quindi:

```bash
php artisan migrate
php artisan storage:link
```

Il collegamento `storage:link` serve per mostrare le immagini caricate (foto profilo, post e momenti).

Avvia il progetto con due terminali aperti nella cartella del progetto:

```bash
npm run dev
```

```bash
php artisan serve
```

L'applicazione sarà disponibile su `http://localhost:8000`.

## Possibili sviluppi

- Chat in tempo reale con WebSocket (ad esempio Laravel Reverb)
- Like ai commenti e notifiche per i commenti
- Pulizia automatica dei momenti scaduti (comando pianificato che elimina record e file)
- Feed limitato alle persone seguite
- Content-Security-Policy più restrittiva (senza `'unsafe-inline'`)
- Test automatici sulle funzionalità principali
- Ambiente Docker (Laravel Sail) e pubblicazione online con demo

## Sicurezza 

Scansione con OWASP ZAP.

## Autore

**Daniele Uva** · [LinkedIn](https://linkedin.com/in/daniele-uva-dev) · [GitHub](https://github.com/DanieleUva)
