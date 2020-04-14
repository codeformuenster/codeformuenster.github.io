---
layout: post
title: Offene Unfallstatistik für Münster
author: Gerald Pape
category: blog
twitter: "@ubergesundheit"
keywords:
  - "Verkehr"
  - "Münster"
  - "Open Data"
  - "Verkehrsunfälle"
  - "Unfälle"
  - "Unfallstatistik"
  - "Verkehrsunfallstatistik"
---

Seit geraumer Zeit beschäftigen wir uns bei Code for Münster mit der
Verkehrsunfallstatistik von Münster.

## Alle Unfälle in Münster

Zu jedem Verkehrsunfall, zu dem die Polizei hinzu gerufen wird, wird ein
Datensatz mit den "Eckdaten" des Unfalls angelegt. Dazu gehört neben der Art
des Unfalls (Auffahrunfall, Abbiegeunfall, ...),
Art und Anzahl der Beteiligten (Auto, Fahrrad, LKW, ...),
Verletzungen/Sachschäden und Unfallursachen auch der Ort des Unfalls. Aus der
Gesamtheit dieser Datensätze errechnet die Polizei dann jährlich
[zusammengefasste Verkehrsunfallstatistiken](https://muenster.polizei.nrw/polizeiliche-verkehrsunfallstatistik-4)
als statisches PDF.

Dank einer
[IfG-Anfrage](https://de.wikipedia.org/wiki/Informationsfreiheitsgesetz)
über
[Frag den Staat](https://fragdenstaat.de/anfrage/rohdaten-der-verkehrsunfallstatistik-munster/)
sind wir 2015 zum ersten mal mit den Rohdaten der Unfallstatistiken 2007 bis
2014 in Kontakt. Über die folgenden Jahre fanden die weiteren Jahresdatensätze
ihren Weg zu uns.

Auf offizieller Seite wird eine Software namens EUSKa (Elektronische Unfalltypensteckkarte) [1]
eingesetzt, um die Unfälle an Zentraler stelle zu speichern und zu analysieren.
Der uns vorliegende Datensatz stammt jedoch aus einer Handgepflegten Excel-Tabelle.

Zum Zeitpunkt dieses Blogposts werden jedoch die Unfalldaten von NRW noch nicht in den
[Unfallatlas des Statistikportal der Statistischen Ämter des Bundes und der Länder](https://unfallatlas.statistikportal.de/)
eingepflegt. Dies soll jedoch ab nächstem Jahr geschehen. [2]

## Was ist im Datensatz

Der uns vorliegende Datensatz besteht aus zwölf Excel-Tabellen und beinhaltet
insgesamt 119616 Einträge aus den Jahren 2007 bis 2018. Die einzelnen Dateien
enthalten zwischen 31 und 38 Spalten mit Angaben je Unfall abhängig vom Jahr.

Obwohl der Datensatz sehr detailliert ist, gibt es leider eine große Schwäche:

Der Ort des Unfalls ist lediglich durch die Spalten "Unfallort" und
"Unfallhöhe" beschrieben. Für eine maschinelle Verarbeitung sind diese Angaben
erst nach einer Nachbearbeitung nutzbar.

Der übliche Weg, um Adressen maschinenlesbar nutzbar zu machen, ist einen so
genannten Geocoder zu verwenden, um ein Koordinatenpaar zu einer
Ortsbescheibung zu finden.

Leider funktioniert dieser Prozess nur für einen Teil der Ortsangaben der
Unfälle.

Durch diesen Umstand ist der Datensatz in seiner Gesamtheit für eine Analyse
auf Ortsebene nicht geeignet.

Den Prozess des importierens lässt sich im
[Quellcode für den Import und die Verarbeitung](https://github.com/codeformuenster/verkehrsunfaelle)
nachverfolgen. Dort finden sich auch Links zu CSV-Exports.

## Was wir bisher erreicht haben

Aufbauend auf dem bisher erstellten Datensatz haben wir eine
[interaktive räumliche Unfalldatenvisualisierung](https://crashes.codeformuenster.org/)
programmiert. Sie erlaubt es, über sämtliche Unfallparameter detailliert zu filtern und
erlaubt es so, Antworten zu eigenen Fragestellungen (zumindest teilweise) zu beantworten.

Am 23.10.2019 berichteten auch die Westfälischen Nachrichten über die Unfalldatenvisualiserung [3].

Für die Vervollständigung des Datensatzes haben wir außerdem einen [Unfalldaten Editor](https://crashes-editor.codeformuenster.org/) enwickelt.
Dieser ermöglicht es, die Ergebnisse des Geocoders zu überprüfen und ggf. zu korrigieren.

Wir würden uns freuen, wenn wir mit Hilfe allen ortskundigen Bürgern Münsters einen
vollständigen Datensatz erarbeiten könnten.

Unser Ziel ist es, die vorhandenen Daten für alle einfach zugänglich zu machen.
Dazu gehören neben einem einheitlichen Datums- und Zeitformat auch die
Maschinenlesbarkeit des Ortes.

Alle Bürger Münsters sind aufgerufen, bei der genauen Ortserfassung aller Unfälle und damit dem besseren
Verständnis von Unfallschwerpunkten in der Stadt beizutragen.

## Warum machen wir das?

Beinahe täglich findet sich ein Bericht über einen Verkehrsunfall auf den Seiten der lokalen Tageszeitung.
Gleichzeitig lassen sich nur schwer Informationen zu Unfällen an bestimmten Orten oder Entwicklungen der Unfälle über die Zeit finden.
Fragen wie "Ist diese Kreuzung ein Unfallschwerpunkt für Fahrradfahrende?" oder "Gab es seit Einführung von Tempo 30 auf Straße X im Schnitt weniger Unfallverletzte als vorher?" lassen sich so nur schwer und von bestimmten Personenkreisen beantworten.

Nach dem Motto "Wissen ist Macht" verleihen jedoch Informationen wie diese der Bevölkerung die Möglichkeit zum informierten und selbstbestimmten Handeln.
Damit solche Fragen in Zukunft jede:r ohne große Barrieren beantworten kann stellen wir in diesem Projekt die gesamten Unfalldaten für Münster zur Verfügung.

Wir können das, weil uns als Bürger:innen durch die Informationsfreiheit im Prinzip der freie Zugang zu sämtlichen amtlichen Informationen garantiert wird.
Wenn du mehr zum Thema Informationsfreiheit wissen möchtest findest du auf [fragdenstaat.de](https://fragdenstaat.de/info/informationsfreiheit/einfuehrung/) eine gute Einführung.

## Wie geht es weiter

Wer bis hier hin durchgehalten hat, wird sicherlich aufgefallen sein, dass das Jahr 2019 mit keinem Wort erwäht wurde.
Das liegt daran, dass trotz mehrfachen Nachfragen die Daten nicht mehr durch die Polizei veröffentlicht werden.
Uns bleibt lediglich auf eine baldige Aktualisierung des Unfallatlas zu hoffen.

Vor uns liegt jedoch auch abseits der Daten von 2019 noch genug Arbeit. Zum Beispiel müssen die Ergebnisse des
Unfalldaten Editor sinnvoll in den Datensatz eingepflegt werden.

Wer jetzt Lust bekommen hat, sich mit uns zusammen weiterhin mit Unfalldaten zu beschäftigen, soll sich gerne melden!

[1]: https://polizei.nrw/artikel/unfallhaeufungsstellen-erkennen-mit-euska
[2]: https://kleineanfragen.de/nordrhein-westfalen/17/7085-wann-kommen-die-daten-aus-nrw-in-den-unfallatlas-der-statistischen-aemter-des-bundes-und-der-laender
[3]: https://www.wn.de/Muenster/Stadtteile/Hiltrup/4007359-Interaktive-Unfallkarte-zeigt-Gefahrenpunkte-in-Hiltrup-Hier-kracht-es-am-Haeufigsten
