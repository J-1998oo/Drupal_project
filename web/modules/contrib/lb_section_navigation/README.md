# Layout builder Section navigation

Adds a new block available to layout builder that
displays a list of anchor links for other components
of the same section.

## How

It will add an id attribute to components in the section
using its UUID, the it will generate a list of links like:
```
<a href="#UUID">Component title</a>
```

This block is generated when the whole section is rendered
as it needs information from the rest of components.
