---
title: Code for Münster Blog
subtitle: Stadtgeschichten aus Münster
layout: page
hero_height: is-small
---
Hier bloggen die Mitglieder von Code For Münster in unregelmäßigen Abständen.

{% for post in site.posts %}
{% include blogpost_link.html post=post %}
<!-- <div class="box">
  <article class="media">
    <div class="media-content">
      <div class="content">
        <h3 class="title is-3">{{ post.title }}</h3>
        <p>
          von <strong>{{ post.author }}</strong>{% if post.twitter %}<small> (<a href="https://twitter.com/{{ post.twitter }}">@{{ post.twitter }}</a>)</small>{% endif %} <small>am {{ post.date | date: "%d.%m.%Y" }}</small>
          <br>
          {{ post.excerpt }}
        </p>
        <a class="button is-link" href="{{ post.url }}">weiterlesen&hellip;</a>
      </div>
    </div>
  </article>
</div> -->
{% endfor %}
