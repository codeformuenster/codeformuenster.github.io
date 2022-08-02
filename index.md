---
layout: page
title: Code for Münster
subtitle: Freie Software & Offene Daten für eine lebenswertere Stadt
hero_height: is-medium
hero_is_landingpage: true
# hero_link: /page-1/
# hero_link_text: Example Call To Action
show_sidebar: false

# images must reside in /assets/img/carousel
# Change number of images in assets/css/app.scss!!!
# should have at least 4 images, otherwise this looks weird
carousel_images:
- alt: Hacknight auf der Terrasse im drei:klang
  file_name: hacknight_terrasse.jpeg
- alt: Visualisierung von Verkehrszählungen in Münster
  file_name: traffics_1.png
  link: https://traffics.codeformuenster.org
- alt: Zu Gast in der B-Side
  file_name: schattenskulptura_hack.jpeg
- alt: Verkehrsunfälle in Münster
  file_name: crashes_1.jpeg
  link: https://crashes.codeformuenster.org
- alt: Open Data Day 2017 in der VHS Münster
  file_name: odd_1.jpeg
- alt: Hacknight auf dem Sofa im drei:klang
  file_name: hacknight_sofa.jpeg
- alt: Vortrag über Open Data und Code for Münster bei 12min.me
  file_name: 12min_tw.jpeg
---


## Wer sind wir?

<div class="Carousel">
  <div class="Carousel-slides">
    {% for item in page.carousel_images %}
    {% capture full_path %}{{site.baseurl}}/assets/img/carousel/{{ item.file_name }}{% endcapture %}
    <div class="Carousel-slide">
      {% if item.link %}
        <a href="{{ item.link }}" class="Carousel-item">
          <img loading="eager" src="{{ full_path }}" alt="{{ item.alt }}">
        </a>
      {% else %}
        <img loading="eager" src="{{ full_path }}" class="Carousel-item" alt="{{ item.alt }}">
      {% endif %}
    </div>
    {% endfor %}
  </div>
</div>

"Code for Münster" ist ein lockerer Zusammenschluss von Menschen, die in ihrer Freizeit ehrenamtlich auf mehr Transparenz der Politik und Verwaltung hinwirken wollen. Dazu versuchen wir Datenschätze der öffentlichen Hand (Stadt, Stadtwerke, etc.) für die Allgemeinheit zu öffnen und zugänglich zu machen. Aus diesen offenen Daten erstellen wir offene und freie Anwendungen, von der die Stadtgesellschaft profitieren soll.

Als wichtiger Baustein unserer Demokratie, ermöglichen es Offene Daten, dass Bürger*innen sich besser über Stadt, Umwelt und Leben informieren und sich beteiligen können.

Klingt interessant? Komm vorbei, wir sind immer offen für neue Leute! Unser regelmäßiges, offenes Treffen "Hacknight" findet jede Woche dienstags um 19:30 Uhr im [Café Drei:klang (Wolbecker Str. 36)](https://www.openstreetmap.org/node/3351819468) statt.

{% include hacknight.html %}

## Weitere Termine

{% include events_showcase.html %}


## Projekte

{% include projects_showcase.html %}

### Weitere Projekte

{% include projects.html %}

## Aktuelle Blog-Artikel

{% for post in site.posts limit:2 %}
{% include blogpost_link.html post=post %}
{% endfor %}
