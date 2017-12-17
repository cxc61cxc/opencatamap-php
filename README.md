# opencatamap-php
Opencatamap php aggiunge e si integra con opencatamap ottenendo funzionalità aggiuntive

Ambiente usato per lo sviluppo ed il testing:
1) computer con ubuntu 16.04 (funzionante anche su release di Ubuntu successive)
1) server apache2 
2) ambiente php su apache2 configurato, la versione testata php 5.5 o successiva 
 con installato il modulo per l'accesso ai files sqlite

sudo apt-get install php-sqlite3


3) aver installato sqlite3 per la parte alfanumerica e spatialite per la parte cartografica

4) gli archivi catastali:
non sono distribuiti, i files di dati di archivio catasto.db e catasto_cart_4326.sqlite,
di competenza per il vostro comune, dovete premurarvi di scaricarli ed trasformarli nel formato adatto..., 
seguendo le indicazioni riportate al sito opencatamap https://github.com/marcobra/opencatamap

I files devono essere copiati nella cartella del server web nella stessa cartella dove risiedono i sorgenti.

Non e' al momento previsto nessun login o accesso limitato da un login con utente e password, pertanto i dati sono potenzialmente esposti a tutti gli utenti che possono accedere liberamente al sito via web.

Cosi come gli archivi essi vanno un poco difesi dall'accesso ed il conseguente download diretto tramite alcune direttive che neghino tale tipo di accesso in apache2.conf si attiva la possibilità che venga letto dal server un file .htaccess   
(il file .htaccess e' già presente nei sorgenti)

```
<Directory /var/www/html/Comune/catasto_cc_10>
     AllowOverride All
</Directory>
```

va fatto ripartire il server apache per controllare che siano attive le modifiche
```sudo service apache2 restart```

Per dare a PHP la possibilità leggere i files sqlite editare il file php.ini

```sudo apt-get install libsqlite3-mod-spatialite```

poi sincerarsi vi sia la seguente istruzione nel file php.ini, aprire il file di configurazione:

```gksudo gedit /etc/php/7.1/apache2/php.ini```

ed impostare il sentiero in conformià a dove si trovano le estensioni per sqlite3, in pratica dove si trova il file mod_spatialite.so :

```
[sqlite3]
sqlite3.extension_dir = /usr/lib/x86_64-linux-gnu
```

Riavviare il server web
```sudo service apache2 restart```




Note: 
E' in sviluppo e prevista, ma non ancora implementata, la possibilità di trasferire i dati su
database nel rdbms: postgresql/postgis 

