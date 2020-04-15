---
layout: post
title: Offene Unfallstatistik für Münster
author: Gerald Pape
category: blog
twitter: "ubergesundheit"
keywords:
  - "Verkehr"
  - "Münster"
  - "Open Data"
  - "Verkehrsunfälle"
  - "Verkehrssicherheit"
  - "Unfälle"
  - "Unfallstatistik"
  - "Verkehrsunfallstatistik"
---

Seit geraumer Zeit beschäftigen wir uns bei Code for Münster mit der
Verkehrsunfallstatistik im Stadtgebiet von Münster.
In diesem Artikel berichten wir von unseren Erfolgen, aber auch unseren Schwierigkeiten mit den Unfalldaten.

## Alle Unfälle in Münster

Zu jedem Verkehrsunfall, zu dem die Polizei hinzu gerufen wird, wird ein
Datensatz mit den "Eckdaten" des Unfalls angelegt. Dazu gehört neben der Art
des Unfalls (Auffahrunfall, Abbiegeunfall, ...),
Art und Anzahl der Beteiligten (Auto, Fahrrad, LKW, ...),
Verletzungen/Sachschäden und Unfallursachen auch der Ort des Unfalls. Aus der
Gesamtheit dieser Datensätze errechnet die Polizei dann jährlich
[zusammengefasste Verkehrsunfallstatistiken](https://muenster.polizei.nrw/polizeiliche-verkehrsunfallstatistik-4)
als statisches PDF.

PDFs sind zwar gut menschenlesbar, aber nur schlecht maschinenlesbar. Wir kommen darüber also nicht an die eigentlichen Unfall-Rohdaten heran.
Darüber hinaus werden in der PDF gar nicht alle Daten genannt, sondern nur Interpretationen der Daten durch die Polizei dargestellt.
So ist zum Beispiel in der Unfallstatistik 2019 auf mehr als einer Seite etwas zu Unfällen, an denen RadfahrerInnen beteiligt waren, zu lesen. Zu Unfällen mit PKW-Beteiligung gibt es nur zwei Sätze in denen auch nur von Unfällen mit verletzten PKW-Insassen geredet wird (anders als bei den Radunfällen).

Dank einer
[IfG-Anfrage](https://de.wikipedia.org/wiki/Informationsfreiheitsgesetz)
über
[Frag den Staat](https://fragdenstaat.de/anfrage/rohdaten-der-verkehrsunfallstatistik-munster/)
haben wir 2015 zum ersten Mal Zugriff auf die Rohdaten der Unfallstatistiken 2007 bis
2014 bekommen. Über die folgenden Jahre fanden die weiteren Jahresdatensätze
ihren Weg zu uns.

Auf offizieller Seite wird eine Software namens [EUSKa (Elektronische Unfalltypensteckkarte)]
eingesetzt, um die Unfälle an zentraler Stelle zu speichern und zu analysieren.
Der uns vorliegende Datensatz stammt jedoch aus einer handgepflegten Excel-Tabelle.

Zum Zeitpunkt dieses Blogposts werden die Unfalldaten ganz NRWs noch nicht in den
[Unfallatlas des Statistikportals der Statistischen Ämter des Bundes und der Länder](https://unfallatlas.statistikportal.de/)
eingepflegt. Dies soll jedoch [Mitte 2020] geschehen.

## Was ist im Datensatz

Der uns vorliegende Datensatz besteht aus zwölf Excel-Tabellen und beinhaltet
insgesamt 119 616 Einträge aus den Jahren 2007 bis 2018.
Die einzelnen Dateien enthalten abhängig vom Jahr zwischen
31 und 38 Spalten (Unfallart, Beteiligte, etc.) zu jedem Unfall.

Obwohl der Datensatz also sehr detailliert ist, gibt es leider eine große Schwäche:
Der Ort des Unfalls ist lediglich durch die Spalten "Unfallort" und
"Unfallhöhe" beschrieben. Für eine maschinelle Verarbeitung sind diese Angaben
erst nach einer Nachbearbeitung nutzbar.

Der übliche Weg, um Adressen maschinenlesbar zu machen, ist es, einen sogenannten Geocoder zu verwenden, um ein Koordinatenpaar zu einer
Ortsbescheibung zu finden.
Leider funktioniert dieser Prozess nur für einen Teil der Ortsangaben der
Unfälle.
Deshalb ist der Datensatz in seiner Gesamtheit für eine Analyse
auf Ortsebene nicht geeignet.
Den Prozess des Importierens lässt sich im
[Quellcode für den Import und die Verarbeitung](https://github.com/codeformuenster/verkehrsunfaelle)
nachverfolgen. Dort finden sich auch Links zu CSV-Exporten.

## Was wir bisher erreicht haben

Aufbauend auf dem bisher erstellten Datensatz haben wir eine
[interaktive räumliche Unfalldatenvisualisierung](https://crashes.codeformuenster.org/)
programmiert. Sie erlaubt es, sämtliche Unfallparameter detailliert zu filtern und
somit Antworten zu eigenen Fragestellungen (zumindest teilweise) zu beantworten.

Neben einem [Artikel in den Westfälischen Nachrichten] konnten wir das Projekt auf dem "Forum Citizen Science" 2019 ([Folien]) in Münster vorstellen.

Für die Vervollständigung des Datensatzes haben wir außerdem einen [Unfalldaten-Editor] enwickelt.
Dieser ermöglicht es, die Ergebnisse des Geocoders zu überprüfen und gegebenenfalls zu korrigieren.
Wir würden uns freuen, wenn wir mit Hilfe aller Bürger Münsters, einen
vollständigen Datensatz erarbeiten könnten.
Unser Ziel ist es, die vorhandenen Daten für alle einfach zugänglich zu machen.
Dazu gehört neben einem einheitlichen Datums- und Zeitformat auch die
Maschinenlesbarkeit des Ortes.
Alle Bürger Münsters sind aufgerufen, bei der genauen Ortserfassung aller Unfälle und damit dem besseren Verständnis von Unfallschwerpunkten in der Stadt beizutragen.
Wer am meisten Unfälle korrigiert, bekommt [einen virtuellen goldenen Pokal]!

## Warum machen wir das?

Beinahe täglich findet sich ein Bericht über einen Verkehrsunfall auf den Seiten der lokalen Tageszeitung.
Gleichzeitig lassen sich nur schwer Informationen zu Unfällen an bestimmten Orten oder Entwicklungen der Unfälle über die Zeit finden.
Fragen wie "Ist diese Kreuzung ein Unfallschwerpunkt für Fahrradfahrende?" oder "Gab es seit Einführung von Tempo 30 auf Straße X im Schnitt weniger Unfallverletzte als vorher?" lassen sich so nur schwer und von bestimmten Personenkreisen beantworten.

Nach dem Motto "Wissen ist Macht" verleihen jedoch Informationen wie diese der Bevölkerung die Möglichkeit zum informierten und selbstbestimmten Handeln.
Damit solche Fragen in Zukunft jede:r ohne große Barrieren beantworten kann, stellen wir in diesem Projekt die gesamten Unfalldaten für Münster zur Verfügung.

Wir können das, weil uns als Bürger:innen durch die Informationsfreiheit im Prinzip der freie Zugang zu sämtlichen amtlichen Informationen garantiert wird.
Wenn du mehr zum Thema Informationsfreiheit wissen möchtest, findest du auf [fragdenstaat.de](https://fragdenstaat.de/info/informationsfreiheit/einfuehrung/) eine gute Einführung.

## Wie geht es weiter

Wer bis hier hin durchgehalten hat, dem wird sicherlich aufgefallen sein, dass das Jahr 2019 mit keinem Wort erwähnt wurde.
Das liegt daran, dass trotz mehrfacher Nachfrage die Polizei die Daten nicht mehr veröffentlicht.
Wir bleiben dran, auch mit Unterstützung des [ADFC Münsterlands]. Anders als in den Vorjahren erhält nämlich auch der ADFC bisher keine Daten mehr.
Sollten wir wider Erwarten die Unfalldaten nicht direkt von der Polizei Münster bekommen, bleibt uns lediglich, auf eine baldige Aktualisierung des Unfallatlas auch mit Daten aus NRW zu hoffen. Und darauf, dass im Unfallatlas ebenso detaillierte Daten zur Verfügung gestellt werden, wie sie die Polizei eigentlich auch vorhält.

Vor uns liegt jedoch, auch abseits der Daten von 2019, noch genug Arbeit. Zum Beispiel müssen die Ergebnisse des
[Unfalldaten-Editor] sinnvoll in den Datensatz eingepflegt werden.

Wer jetzt Lust bekommen hat, sich mit uns zusammen weiterhin mit Unfalldaten zu beschäftigen, soll sich gerne melden! Wir treffen uns [jeden Dienstag Abend] und freuen uns immer über neue Gesichter!

[EUSKa (Elektronische Unfalltypensteckkarte)]: https://polizei.nrw/artikel/unfallhaeufungsstellen-erkennen-mit-euska
[Mitte 2020]: https://kleineanfragen.de/nordrhein-westfalen/17/7085-wann-kommen-die-daten-aus-nrw-in-den-unfallatlas-der-statistischen-aemter-des-bundes-und-der-laender
[Artikel in den Westfälischen Nachrichten]: https://www.wn.de/Muenster/Stadtteile/Hiltrup/4007359-Interaktive-Unfallkarte-zeigt-Gefahrenpunkte-in-Hiltrup-Hier-kracht-es-am-Haeufigsten
[Folien]: https://github.com/codeformuenster/crashes-shiny/blob/master/doc/vortrag_forum_citizen_science_september_2019/PVI_Terstiege_SichererRadfahren_26Sep.pdf
[ADFC Münsterlands](https://www.adfc-nrw.de/kreisverbaende/kv-muenster/willkommen-beim-adfcnbspim-muensterland.html)
[Unfalldaten-Editor]: https://crashes-editor.codeformuenster.org/
[einen virtuellen goldenen Pokal]: https://crashes-editor.codeformuenster.org/
[jeden Dienstag Abend](https://codeformuenster.org/)
