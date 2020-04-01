---
title: Code for Münster in der Presse
layout: page
hero_height: is-small
---

Unsere Arbeit findet Beachtung in Gesellschaft und Presse.
Auf dieser Seite geben wir eine kleine Übersicht zu Presseberichten über Code for Münster und Projekten.

{% assign sorted_articles = site.data.presse | sort:"wann" |reverse %}

{% for article in sorted_articles %}
- [{{ article.wann | date: "%d.%m.%Y" }}, {{ article.wer }}: {{ article.thema }}]({{ article.link }})
{% endfor %}

