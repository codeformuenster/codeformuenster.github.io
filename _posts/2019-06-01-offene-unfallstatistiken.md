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

## Was ist im Datensatz

Der uns vorliegende Datensatz besteht aus zwölf Excel-Tabellen und beinhaltet
insgesamt 119616 Einträge aus den Jahren 2007 bis 2018. Die einzelnen Dateien
enthalten zwischen 31 und 38 Spalten mit Angaben je Unfall abhängig vom Jahr.

Obwohl der Datensatz sehr detailliert ist, gibt es leider eine große Schwäche:

Der Ort des Unfalls ist lediglich durch die Spalten "Unfallort" und
„Unfallhöhe“ beschrieben. Für eine maschinelle Verarbeitung sind diese Angaben
erst nach einer Nachbearbeitung nutzbar.

Der übliche Weg, um Adressen maschinenlesbar nutzbar zu machen, ist einen so
genannten Geocoder zu verwenden, um ein Koordinatenpaar zu einer
Ortsbescheibung zu finden.

Leider funktioniert dieser Prozess nur für einen Teil der Ortsangaben der
Unfälle.

Durch diesen Umstand ist der Datensatz in seiner Gesamtheit für eine Analyse
auf Ortsebene nicht geeignet.

## Das Ziel

Unser Ziel ist es, die vorhandenen Daten für alle einfach zugänglich zu machen.
Dazu gehören neben einem einheitlichen Datums- und Zeitformat auch die
Maschinenlesbarkeit des Ortes.

## Mithelfen

Derzeit wird noch fleissig an unserem Editor zur manuellen Überprüfung der
Unfalldaten gearbeitet. Der
[aktuelle Sourcecode](https://github.com/codeformuenster/verkehrsunfaelle-editor)
ist bereits bei GitHub zu finden. Programmierer mit den entsprechenden
Kenntnissen können sich gerne an der Entwicklung beteiligen, ansonsten sind
genauso Tester gesucht, die Feedback zur Benutzung des Tools liefern.

Nach Fertigstellung des Tools sind alle Bürger Münsters aufgerufen, mit dem
Editor zur genauen Ortserfassung aller Unfälle und damit dem besseren
Verständnis von Unfallschwerpunkten in der Stadt beizutragen.
