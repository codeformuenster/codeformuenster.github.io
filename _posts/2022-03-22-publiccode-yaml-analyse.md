---
layout: post
title: Open Source Code öffentlicher Verwaltungen am Beispiel Italien
author: Thomas Werner
category: blog
twitter: toms_rocket
keywords:
  - "Open Source"
  - "Italien"
  - "Public Code"
---

In Italien gibt es einen Metadaten-Standard für Software, die von der öffentlichen Verwaltung entwickelt oder erworben wurde. Und zwar besagt der Standard, dass in jedem GIT(Hub)-Repository, das entsprechenden öffentlich geförderten Quellcode enthält, eine Datei mit dem Namen "publiccode.yml" liegen soll. Diese Datei enthält verschiedene Informationen über das Repository bzw. über die enthaltene Software.

Dadurch sollen diese Sourcecodes leicht auffindbar und damit für andere Stellen wiederverwendbar gemacht werden.

## Open Source Code der Öffentlichen Verwaltung

Die [Beschreibung auf "Docs Italia"](https://docs.italia.it/italia/developers-italia/publiccodeyml-en/en/master/index.html) sagt dazu folgendes: *"Indem eine Datei mit dem Namen `publiccode.yml` in das Stammverzeichnis eines Repositorys aufgenommen und mit Informationen über die Software gefüllt wird, können Software-Entwickler diese bewerten. Da das Format sowohl für Menschen als auch für Maschinen leicht lesbar sein soll, können auch automatische Indizierungswerkzeuge erstellt werden."*

Eine gute Theorie. Leider habe ich keine Liste aller Repositories gefunden, die eine Publiccode-Datei enthalten. Entsprechend gibt es anscheinend auch noch keine Liste, in der diese Repositories systematisch bewertet werden. In einem Thread im CodeForGermany-Slack-Chat hat dann jemand [eine GitHub-Suchanfrage formuliert, die alle Repositories mit publiccode.yml-Datei auflistet](https://github.com/tomsrocket/github-publiccode/blob/1a5ebd346e1e51128918f882dad38cadcd5ee78c/find-publiccode.py#L23). Ich hab das zum Anlass genommen, die Repositories anhand der GitHub-Suche auszulesen und automatisiert auszuwerten.

Weitere Informationen zum Publiccode.yml-Standard finden sich [auf der offiziellen italienischen Seite zum Publiccode-Standard](https://docs.italia.it/italia/developers-italia/publiccodeyml-en/en/master/index.html).

Das Ergebnis ist in folgender Tabelle zu sehen:
(Die Datenbasis wurde erzeugt im März 2022)

## Übersicht der Repositories

 <iframe width="100%" height="500" src="https://tomsrocket.github.io/github-publiccode/public/" title="OSS Developer Community Health Analysis for Publiccode GitHub Repositories"></iframe>
Quelle: [https://tomsrocket.github.io/github-publiccode/public/](https://tomsrocket.github.io/github-publiccode/public/)

<br />
Die Tabelle listet ab Spalte 8 die allgemeinen Informationen der Repositories auf: Repository Url, Repository Name, Name der Organisation bei der das Repository bei GitHub beheimatet ist, Programmiersprache, Landessprache, etc..

Die Spalten 1-7 enthalten Meta-Informationen zu den Software-Repositories selbst. Diese Meta-Informationen werden im Folgenden beschrieben.

## Versuch einer Bewertung der Repositories

Über die GitHub-API können für jedes Repository einige interessante Werte abgerufen werden:

* Wann war der letzte Commit?
* Wie viele Commits gab es bisher insgesamt?
* Wie viele unterschiedliche Committer, bzw. "Contributors" hat das Repository?
* Wie viele Commits haben die Committer beigetragen
* Wie viele Stars hat das Repository auf GitHub?

Anhand dieser Kennzahlen lässt sich schon relativ gut abschätzen, ob hinter dem Repository eine lebendige Community steht, und ob das Projekt noch aktiv weiterentwickelt wird:
* **Letzter Commit mehrere Jahre alt** => Projekt ist nicht mehr in aktiver Entwicklung
* **Nur sehr wenige Commits** => Risiko eines "Fake"-Open-Source-Projekts, ohne richtige Community dahinter. Z.B.: Eine Firma entwickelt es intern, und postet nur ab und an den gesamten aktuellen Quellcode in einem einzelnen Commit.
* **Nur eine Hand voll Contributors** => Keine besonders große Entwickler-Community, hoher "Bus-Factor" (Wie viele Leute können vom Bus überfahren werden, ohne dass ein Weiterführen des Projekts gefährdet wäre)
* **Nur wenige Stars** => Eher unbekanntes Projekt ohne viele "Fans"

Diese Kennzahlen werden in der Tabelle oben in den Spalten 3-6 angezeigt.

Spalte 1 enthält zuätzlich einen Farbcode nach Ampel-Schema, der sich aus diesen Kennzahlen errechnet und die "Qualität" der jeweiligen Entwicklercommunity visualisieren soll.

Wenn man dann mal schaut, wie viele Repositories nach diesem Schema ein gutes Ranking haben, dann sieht das so aus:

 <iframe width="100%" height="400" scrolling="no" src="https://tomsrocket.github.io/github-publiccode/public/analysis-1.html"></iframe>

Nur etwa ein Viertel der Repositories werden aktiv weiterentwickelt und haben eine aktive Community.

Man könnte nun meinen, das wäre ein schlechter Wert. Aber genauer betrachtet ist bei Quellcode, der von öffentlichen Stellen finanziert wird, ja nicht gefordert, dass dahinter eine aktive Open-Source-Community steht. Vielmehr geht es darum, dass der Code überhaupt als Open Source bereitgestellt wird, und wenn dann sogar 25% davon eine aktive Entwicklercommunity haben, dann ist das ein gutes Ergebnis.

Stichproben bei den Repositories mit schlechten Community-Ratings haben außerdem ergeben, dass diese auch gar nicht unbedingt aktiv bei GitHub weiterentwickelt werden müssen:
* Quellcode statischer Infos-Webseiten
* Wikis (der Content liegt nicht im Repository, sondern in einer extra Datenbank)
* Desktop-Anwendungen, die über eine Projektlaufzeit entwickelt wurden => Solange die Anwendung funktioniert, muss natürlich nichts weiterentwickelt werden. Allerdings heißt das auch, dass über den Zeitraum keine Fehler behoben oder Dependencies geupdatet wurden, somit ist dies mit Vorsicht zu genießen.

Schauen wir, welche weiteren Informationen aus der Liste ableitbar sind:

## Weitere Auswertungen der Repositories

Interessant ist vielleicht, unter welchen Lizenzen der jeweilige Code steht, und welche Programmiersprachen am häufigsten verwendet wurden:

 <iframe width="100%" height="410" scrolling="no" src="https://tomsrocket.github.io/github-publiccode/public/analysis-2.html"></iframe>
Quelle: [https://tomsrocket.github.io/github-publiccode/public/analysis.html](https://tomsrocket.github.io/github-publiccode/public/analysis.html)
<br />

**Lizenzen**<br />
Bei den Lizenzen fällt auf, dass der Großteil der Software (mind. 75%) unter Copyleft-Lizenzen steht (EUPL, AGPL, GPL, .. ) und nur ein relativ kleiner Anteil an freizügigen Open-Source-Lizenzen genutzt wird (Apache-, MIT-Lizenz, ..).
Aus Open-Source-"Hardliner"-Sicht ist das natürlich erfreulich, wird hiermit doch eine Kommerzialisierung dieser Softwareprojekte erschwert, und statt dessen der Aufbau eines Kataloges an offenem, digitalen Allgemeingut unterstützt.

**Programmiersprachen**<br />
Die Topliste der verwendeten Programmiersprachen entspricht weitestgehend den [diversen im Internet kursierenden Listen der meistgenutzten Programmiersprachen weltweit](https://www.google.com/search?q=%22meistgenutzte+Programmiersprachen+weltweit%22). Java liegt mit 66 Repositories bzw. 22% höher als erwartet. Aber wenn man genauer hinschaut, stellt man fest, dass z.B. die ["Regione Marche"](https://github.com/regione-marche) sehr viele Java-Repositories veröffentlicht, die allesamt ein und der gleichen E-Procurement-Lösung zuzuordnen sind. Dass eine Software, die z.B. in Microservice- oder Plugin-Architektur erstellt wurde und daher über viele Einzelrepositories verteilt ist, in dieser Liste überproportional einfließt, ist ein Gesichtspunkt, der in dieser Analyse nicht näher berücksichtigt wird, und generell die Ergebnisse verfälschen kann.

## Anwendungstypen

Was könnte man sich sonst noch anschauen? z.B. welchen Anwendungstypen und welchen Themen sind die geförderten Software-Repositories zuzuordnen?

 <iframe width="100%" height="410" scrolling="no" src="https://tomsrocket.github.io/github-publiccode/public/analysis-3.html"></iframe>
Quelle: [https://tomsrocket.github.io/github-publiccode/public/analysis.html](https://tomsrocket.github.io/github-publiccode/public/analysis.html)
<br />

 <iframe width="100%" height="410" scrolling="no" src="https://tomsrocket.github.io/github-publiccode/public/analysis-4.html"></iframe>
Quelle: [https://tomsrocket.github.io/github-publiccode/public/analysis.html](https://tomsrocket.github.io/github-publiccode/public/analysis.html)
<br />

## Fazit

Dass öffentlich geförderter Code als Open Source bereitgestellt werden muss, ist eine sehr gute Vorgabe. Man muss bedenken, dass es sich hier um Code handelt, der üblicherweise mit Steuergeldern bezahlt wurde, und somit sollte auch der Quellcode als digitales Allgemeingut wieder an die Allgemeinheit zurückfließen.

Das Auffinden solchen Codes wäre normalerweise in den Weiten des Internets fast unmöglich. Dass diese Code-Repositories eine "publiccode.yml"-Datei enthalten müssen, ist zwar eine gute Idee, funktioniert aber nur eingeschränkt. In diesem Fall wurden nur Repositories betrachtet, die bei GitHub verwaltet werden und das dürfte nur auf einen Bruchteil der öffentlich geförderten Repositories zutreffen.

## Ausblick

In Frankreich gibt es [eine zentrale Liste allen öffentlich geförderten Codes unter code.gouv.fr](https://code.gouv.fr). Diese Liste ist [bereits in einem maschinenlesbaren JSON-Format verfügbar](https://code.gouv.fr/data/repos.json) und könnte in einem nächsten Schritt betrachtet werden.

In Deutschland gibt es Bestrebungen, ebenfalls die "publiccode.yml" zu nutzen, zusätzlich zu einem öffentlichen Code-Repository ähnlich GitHub.com, basierend auf GitLab. Dazu wurde im April 2022 das Projekt [opencode.de](https://opencode.de/) geschaffen. Das ist sehr zu begrüßen, fördert es doch die Transparenz und ermöglicht eine Nachnutzung von staatlich entwickelten Tools in verschiedenen Bundesländern und auf verschiedenen Staatsebenen wie Bund, Ländern und Kommunen. Das könnte in einem föderalen System wie in Deutschland durch eine Nachnutzung von Software große Synergieeffekte haben.

## Abschließende Hinweise
Die hier wiedergegebenen Aussagen spiegeln die private Meinung des Autors wieder.
Der Code zur Erstellung der Software-Liste sowie zur Erstellung der Diagramme steht auf [GitHub](https://github.com/tomsrocket/github-publiccode) zur Verfügung.
