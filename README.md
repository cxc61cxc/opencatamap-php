# opencatamap-php
Opencatamap php aggiunge e si integra con opencatamap ottenendo funzionalità aggiuntive

Ambiente usato per lo sviluppo ed il testing:
1) computer con ubuntu 16.04
1) server apache2 
2) ambiente php su apache2 configurato, la versione testata php 5.5 
con installato il modulo per la laettura dei file sqlite

sudo apt-get install php-sqlite3

3) aver installato sqlite3 per la parte alfanumerica e spatialite per la parte cartografica

4) archivi catastali:
non sono distribuiti, i files di dati di archivio catasto.db e catasto_cart_4326.sqlite,
di competenza per il vostro comune, dovete premurarvi di scaricarli ed trasformarli nel formato adatto..., 
seguendo le indicazioni riportate al sito opencatamap https://github.com/marcobra/opencatamap

I files devono essere copiati nella cartella del server web nella stessa cartella dove risiedono i sorgenti.

Non e' al momento previsto nessun login o accesso limitato da un login con utente e password, pertanto i dati sono potenzialmente esposti a tutti gli utenti che possono accedere liberamente al sito via web.

Cosi come gli archivi essi vanno un poco difesi dall'accesso ed il conseguente download diretto tramite alcune direttive che neghino tale tipo di accesso in apache2.conf si attiva la possibilità che venga letto dal server un file .htaccess   
(il file .htaccess e' già presente nei sorgenti)

<Directory /var/www/html/Comune/catasto_cc_10>
     AllowOverride All
</Directory>

va fatto ripartire il server apache per controlare siano attive le modifiche



Note: 
E' in sviluppo e prevista, ma non ancora implementata, la possibilità di trasferire i dati su
database nel rdbms: postgresql/postgis 

