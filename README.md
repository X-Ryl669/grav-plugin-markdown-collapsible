# Grav Markdown Collapsible Plugin

The **markdown-collapsible plugin** for [Grav](http://github.com/getgrav/grav) allows generation of collapsible blocks of text via markdown:
<details><summary>Some title</summary>

The *main text goes here*
</details>

The plugin is shamelessly inspired by Markdown notices

# Installation

This plugin is easy to install with GPM.

```
$ bin/gpm install markdown-collapsible
```

# Configuration

Simply copy the `user/plugins/markdown-collapsible/markdown-collapsible.yaml` into `user/config/plugins/markdown-collapsible.yaml` and make your modifications.

```
enabled: true
built_in_css: true
```
## Offsetting the smooth scroll behaviour
In situations where a top offset is desired for the scroll-to behaviour when a section is revealed, custom CSS can be used to do so. This is especially useful when your theme has a sticky header or navigation that obscures the top of the expanded content when opened.
The relatively new `scroll-margin` CSS property provides the mechanism as described in [this Stackoverflow](https://stackoverflow.com/questions/24665602/scrollintoview-scrolls-just-too-far/56391657#answer-67923821) response.

An plugin configuration option to specify this value may be added in a future release.

# Examples

A collapsible section is made of a title and some content that's initially hidden and appears when it's clicked. 
It requires two tags: `!>` for the title and `!@` for the end of the content. The content can contains markdown by itself. 

```
!> My section

### Whatever markdown you need

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris feugiat quam erat, ut iaculis diam posuere nec.
Vestibulum eu condimentum urna. Vestibulum feugiat odio ut sodales porta. Donec sit amet ante mi. Donec lobortis
orci dolor. Donec tristique volutpat ultricies. Nullam tempus, enim sit amet fringilla facilisis, ipsum ex
tincidunt ipsum, vel placerat sem sem vitae risus. Aenean posuere sed purus nec pretium.
!@
```

You will output the following HTML:

```
<input type="checkbox" id="my-section">
<label for="my-section">My section</label>
<div class="collapsible">
    <h3> Whatever markdown you need </h3>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris feugiat quam erat, ut iaculis diam posuere nec.
        Vestibulum eu condimentum urna. Vestibulum feugiat odio ut sodales porta. Donec sit amet ante mi. Donec lobortis
        orci dolor. Donec tristique volutpat ultricies. Nullam tempus, enim sit amet fringilla facilisis, ipsum ex
        tincidunt ipsum, vel placerat sem sem vitae risus. Aenean posuere sed purus nec pretium.
    </p>
</div>
```

If you want an accordion style (that is, only a single section is opened at a time), you'll use the special syntax:
`!>[name] My section`.
All sections declared with the same name will fold/unfold so only one is visible at a time.


Example usage in Grav [here](https://blog.cyril.by/en/documentation/emqtt5-doc/emqtt5)
