.. include:: /Includes.rst.txt

.. _admin_upgrade_12.0:

==========================================
Upgrade to version 12.0
==========================================

Version 12 adapts to version 12 from the bootstrap package hence provides
compatibility with
`TYPO3 version 11 <https://typo3.org/help/documentation/whats-new>`__ and
`bootstrap framework version 5 <https://getbootstrap.com>`__.

Using bootstrap 4
=================

Bootstrap 5 is enabled by default. To use bootstrap 4 the related static templates need to be loaded as following:

*  "Bootstrap Package: Bootstrap 4.x (SCSS)" after "Bootstrap Package: Full Package"
*  "Pizpalue - Bootstrap 4.x" after "Pizpalue - Main"

.. figure:: ../Images/Administration/Upgrade12_Bootstrap4_StaticTemplate.jpg
   :width: 500px
   :alt: Static templates to use bootstrap 4

   Static templates to use bootstrap 4

Breaking changes
================

Drop classes for vertical alignment (07.12.2021, eb20e89)
---------------------------------------------------------

Description
~~~~~~~~~~~
The classes `pp-parentheight`, `pp-parent-height`,
`pp-row-height` and `pp-row-child-height` have
been removed.

Corrective action
~~~~~~~~~~~~~~~~~
Add the functionality with flexbox or js to
the site package.

Migrate layout "Emphasize media" to ce (26.11.2021, f1cf626)
------------------------------------------------------------

Description
~~~~~~~~~~~

The layout option "Emphasize media" has been removed in
favor of an own content element. As a result the frame
class `frame-layout-pp-emphasize-media` isn't used
anymore.

Corrective action
~~~~~~~~~~~~~~~~~

Review the site package for possible references to the
class `frame-layout-pp-emphasize-media` and correct
them accordingly.


Reduce supported extensions (16.11.2021, b5d9464)
-------------------------------------------------

Description
~~~~~~~~~~~

Support for extensions not being available for
TYPO3 v11 has been dropped.

Correct content element css classes (12.11.2021, 6770c61)
---------------------------------------------------------

Description
~~~~~~~~~~~

The bootstrap package introduced the field `frame_layout`.
To distinguish classes related to the `layout` field the
prefix has been changed from `frame-layout` to `layout-`.
The prefix `layout-` is not added to tile layouts.

ATTENTION: Classes related to the field `frame_layout`
are now prefixed with `frame-layout`.

Corrective action
~~~~~~~~~~~~~~~~~

Adapt the style definitions in the site package if the
class `frame-layout-pp-emphasize-media` has been used.

Remove rarely used animation (12.11.2021, 5ffdfb4)
--------------------------------------------------

Description
~~~~~~~~~~~

The content animation "Zoom background, show text" has
been removed.

Corrective action
~~~~~~~~~~~~~~~~~

To further use the animation add it to your site package

Remove app icon meta tags (06.11.2021, f65cb3a)
-----------------------------------------------

Description
~~~~~~~~~~~

When defining `page.favicon.file = appIcon`
additional meta tags related to the app icon
could be embedded to the page. This has rarely
been used.

Corrective action
~~~~~~~~~~~~~~~~~

In case the app icon meta tags are needed define
them in the site package.

Remove deprecated backend layouts (24.09.2021, d076e08)
-------------------------------------------------------

Description
~~~~~~~~~~~

The deprecated backend layouts `Full width clean` and
`Full width default` are removed.

Corrective action
~~~~~~~~~~~~~~~~~

If needed add the layouts to the site package.

Remove figcaption alignment for image ce's (03.09.2021, d34c8e7)
----------------------------------------------------------------

No further details available.

Refactor typoscript (02.09.2021, 0ddbc3e)
-----------------------------------------

Description
~~~~~~~~~~~

Configurations for the extension `sr_language_menu` have
been moved to a static template.

Corrective action
~~~~~~~~~~~~~~~~~

Add the static template to the template record if the
language menu is rendered with the extension
`sr_language_menu`.

Add support for Bootstrap v5 (28.08.2021, 4b9b1aa)
--------------------------------------------------

Description
~~~~~~~~~~~

The default SCSS variables changed which impacts
rendering.

Corrective action
~~~~~~~~~~~~~~~~~

Review rendering and adapt the site package as needed.

Related: benjaminkott/bootstrap_package 8c63fd58

Correct issues related to frame layout feature (25.08.2021, 104af36)
--------------------------------------------------------------------

Description
~~~~~~~~~~~

Remove direct child selector for classes used in the
content element appearance tab as well as for tiles.
As a result child elements might be affected too.

Corrective action
~~~~~~~~~~~~~~~~~

Adapt the css for child elements in the site package.

Adapt to "Drop webfontloader" (24.08.2021, 91189c0)
---------------------------------------------------

Corrective action
~~~~~~~~~~~~~~~~~

See `bootstrap package wiki pages <https://github.com/benjaminkott/bootstrap_package/wiki>`__

Related: benjaminkott/bootstrap_package e4c07088

Adapt to feature "embedded frame introduction" (24.08.2021, b9976c6)
--------------------------------------------------------------------

Description
~~~~~~~~~~~

New css variables and html wrapping containers are introduced.
This might impact the design.

Corrective action
~~~~~~~~~~~~~~~~~

Style definitions and fluid layouts, templates and partials
should be reviewed.


Remove deprecated theme (23.08.2021, 52c4407)
---------------------------------------------

Description
~~~~~~~~~~~

The following css classes are removed:

pp-ce-margin, pp-ce-padding, pp-ce-bgwhite70,
pp-ce-bggrey70, pp-ce-bgblack70, pp-ce-background,
pp-ce-bgfixed, pp-content-margin, pp-content-padding,
pp-content-bgwhite70, pp-content-bggrey70,
pp-content-bgblack70, pp-cf

Corrective action
~~~~~~~~~~~~~~~~~

Define the needed classes in the site package.

Move TS constants for tt_address display modes (23.08.2021, 171a7bd)
--------------------------------------------------------------------

Description
~~~~~~~~~~~

The TS constants are moved from:

- `pizpalue.plugin.tx_ttaddress.googleMap` to
  `plugin.tx_ttaddress.displayMode.ppGoogleMap`

- `pizpalue.plugin.tx_ttaddress.teaser` to
  `plugin.tx_ttaddress.displayMode.ppTeaser`

Corrective action
~~~~~~~~~~~~~~~~~

Update the related constant definitions in the site
package.


Move tt_address display modes (23.08.2021, 7444801)
---------------------------------------------------

Description
~~~~~~~~~~~

The display modes "Google Map View" and "Teaser" are
moved to the directory `Extensions/tt_address/DisplayMode`.

Corrective action
~~~~~~~~~~~~~~~~~

- Update all template records where the static templates for the display
  modes are used.

- Update all paths to the static templates in the site
  package.


Streamline TSconfig files from extensions (23.08.2021, aa0715f)
---------------------------------------------------------------

Description
~~~~~~~~~~~

Page TSconfig for supported extensions is now available
in `Extensions/[extkey]/Configuration/TsConfig/Page.tsconfig`

Corrective action
~~~~~~~~~~~~~~~~~

In case a site package references page TSconfig files from
pizpalue the pathes need to be updated.


Remove ts property noFrameVariants (23.08.2021, a670f47)
--------------------------------------------------------

Description
~~~~~~~~~~~

The typoscript path `lib.contentElement.settings.
responsiveimages.noFrameVariants` has been removed.

Corrective action
~~~~~~~~~~~~~~~~~

Use `lib.contentElement.settings.responsiveimages
.pageVariants` instead.

Remove deprecated frame classes (23.08.2021, 2dbfc00)
-----------------------------------------------------

Description
~~~~~~~~~~~

The following content element frames were removed:
pp-animation1, pp-animation2, pp-animation3,
ppCefScrollAnimation1, pp-scrollanimation2,
pp-scrollanimation3

Corrective action
~~~~~~~~~~~~~~~~~

- Define the required frame classes in the site package
  as needed.

- Update the fluid layout/template to render the
  attributes.


Remove deprecated js (23.08.2021, 61d5fee)
------------------------------------------

Description
~~~~~~~~~~~

Removes the js module `pizpalue` as well as the function
`getUrlParameter`.

Corrective action
~~~~~~~~~~~~~~~~~

JS scripts referring to the module `pizpalue` should use
`pp` instead and the function call `getUrlParameter` should
be replaced with `pp.getUrlParameter`.

Remove content element inline background image (23.08.2021, d3e9340)
--------------------------------------------------------------------

Description
~~~~~~~~~~~

Pizpalue provided the possibility to define a background
image for a content element. Since the bootstrap package
provides the same functionality it can be removed here.

Corrective action
~~~~~~~~~~~~~~~~~

Use the background image provided by the bootstrap package.

Remove view helper structure.multiplier.getFromText (23.08.2021, e288484)
-------------------------------------------------------------------------

Corrective action
~~~~~~~~~~~~~~~~~

Use `pp:data.imageVariantsTextToArray` view helper instead.

Streamline support for tt_address (23.08.2021, b1b2484)
-------------------------------------------------------

Description
~~~~~~~~~~~

Support for older versions of `tt_address` has been
dropped and adjustments have been moved from
`Extensions/tt_address/4.3.0` to `Extensions/tt_address`.
The static template has been renamed.

Corrective action
~~~~~~~~~~~~~~~~~

- Update the extension `tt_address` to version 4.3.0
  or higher.

- Update all template records where the static template
  for tt_address is used.

- Update all paths to the static template in the site
  package.

Remove support for less (23.08.2021, 05b39e0)
---------------------------------------------

Corrective action
~~~~~~~~~~~~~~~~~

Installation using less files from pizpalue need to
define their own less files.

Remove support for bootstrap3 (21.08.2021, 55bd57b)
---------------------------------------------------

Description
~~~~~~~~~~~

The bootstrap3 framework has been removed.

Corrective action
~~~~~~~~~~~~~~~~~

Site packages making use from the bootstrap3 framework
provided by pizpalue need to embed bootstrap3
by them self.

Streamline prefixes in TS (21.08.2021, 25c4c93)
-----------------------------------------------

Description
~~~~~~~~~~~

The prefixes used to add css/scss and js has
been changed to `pp`.

Corrective action
~~~~~~~~~~~~~~~~~

Site packages overriding typoscript configuration
from pizpalue for css/scss and js should be updated.
