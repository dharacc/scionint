=== YITH WooCommerce Brands Add-On ===

Contributors: yithemes
Tags: brand, brands, logo, manufacturer, yit, e-commerce, ecommerce, shop, supplier, woocommerce brand, woocommerce filter, filter, brand filter, woocommerce manufacturer, woocommerce supplier, brands for woocommerce, brands for wc, product brands, brands for products
Requires at least: 5.3
Tested up to: 5.6
Stable tag: 1.4.1
License: GPLv2 or later
Documentation: http://yithemes.com/docs-plugins/yith-woocommerce-brands-add-on

== Changelog ==

= 1.4.1 - Released on 13 January 2021 =

* Fix: prevent fatal error on PHP 7.2 or older

= 1.4.0 - Released on 12 January 2021 =

* New: support for WooCommerce 4.9
* Update: plugin framework
* Update: Swiper library to version 6.4.5
* Tweak: updated assets versions
* Tweak: added correct handling for brand_thumbnail shortcode params, where missing
* Tweak: improved code that removes empty terms from query
* Dev: added exclude parameter to yith_wcbr_brand_filter shortcode
* Dev: added new filter yith_wcbr_thumbnail_cols_width

= 1.3.15 - Released on 09 December 2020 =

* New: support for WooCommerce 4.8
* Update: plugin framework
* Dev: added new filter yith_wcbr_taxonomy_args

= 1.3.14 - Released on 10 November 2020 =

* New: support for WordPress 5.6
* New: support for WooCommerce 4.7
* New: possibility to update plugin via WP-CLI
* Update: plugin framework
* Dev: removed deprecated .ready method from scripts
* Dev: added new yith_wcbr_thumbnail_shortcode_atts filter
* Dev: added new yith_wcbr_single_product_brand_template_args filter
* Dev: added third parameter to yith_wcbr_brand_filter_heading_letter filter

= 1.3.13 - Released on 15 October 2020 =

* New: support for WooCommerce 4.6
* Update: plugin framework
* Tweak: added title to brand image anchor on loop
* Dev: added new filter yith_wcbr_taxonomy_hierarchical

= 1.3.12 - Released on 17 September 2020 =

* New: support for WooCommerce 4.5
* Update: plugin framework
* Fix: remove usage of deprecated action add_tag_form
* Fix: brand product slider not working correctly
* Dev: remove reference to swiper-bundle.min.js.map to avoid console warning

= 1.3.11 - Released on 13 August 2020 =

* New: support for WordPress 5.5
* New: support for WooCommerce 4.4
* Update: plugin framework
* Update: bundled Swiper library to version 6.0.4
* Tweak: added support for YOAST canonical url

= 1.3.10 - Released on 10 June 2020 =

* New: support for WooCommerce 4.2
* Update: plugin framework
* Tweak: added 'exclude' attribute to exclude brands for brand thumbnail shortcode
* Fix: pagination on brands filter shortcode

= 1.3.9 - Released on 11 May 2020 =

* New: support for WooCommerce 4.1
* Update: plugin framework
* Tweak: added category filter on brand grid shortcode
* Fix: improved method that checks whether coupon is valid for cart
* Dev: added new filter 'yith_wcbr_brand_filter_available_filters'
* Dev: added new filter 'yith_wcbr_csv_connection_importer_product_id'
* Dev: added new filter 'yith_wcbr_csv_connection_importer_term_id'

= 1.3.8 - Released on 11 March 2020 =

* New: support for WordPress 5.4
* New: support for WooCommerce 4.0
* New: added Elementor widgets
* Tweak: code reformat
* Fix: better filter handling for brand names starting with a number or special character

= 1.3.7 - Released on 23 December 2019 =

* New: support for WooCommerce 3.9
* Update: plugin framework
* Tweak: added brand rewrite among permalinks optional settings
* Tweak: fix product rewrite, when it only contains %yith_product_brand%
* Dev: added yith_wcbr_change_brand_name_in_filter filter

= 1.3.6 - Released on 06 November 2019 =

* New: support for WordPress 5.3
* New: support for WooCommerce 3.8
* Update: Plugin Framework
* Update: Italian language
* Update: Spanish language
* Update: Dutch language
* Fix: prevent error with empty allowed and excluded brands on coupon validation
* Fix: call the correct class for brand_filter static function
* Fix: warning on cart, when brand options for the coupon are empty
* Fix: now filters & pagination behave correctly together on brands_filter shortcode
* Fix: order by name if no filter is selected
* Fix: notice on brand category shortcode

= 1.3.5 - Released on 09 August 2019 =

* New: WooCommerce 3.7.0 RC2 support
* New: added coupons restrictions for brands
* Update: internal plugin framework
* Dev: new filter yith_wcbr_brand_filter_widget_atts

= 1.3.4 - Released on 29 May 2019 =

* New: Support to WordPress 5.2
* Update: Plugin Framework

= 1.3.3 - Released on 04 April 2019 =

* New: WooCommerce 3.6.0 RC1 support
* Update: Spanish language
* Update: internal plugin framework
* Dev: added new filter yith_wcbr_brand_taxonomy_columns
* Dev: added new filter yith_wcbr_brand_taxonomy_column
* Dev: added new filter yith_wcbr_image_size_single_product_brads
* Dev: added new filter yith_wcbr_thumbnail_image on thumbnail carousel shortcode

= 1.3.2 - Released on 31 January 2019 =

* New: WooCommerce 3.5.4 support
* New: added brands to product structured data
* Tweak: brands are now correctly added to the new product, when duplicating an existing one
* Update: Italian language
* Updated: Dutch language
* Update: internal plugin framework
* Fix: preventing warning when trying to explode an array
* Fix: preventing notices caused by undefined indexes
* Dev: added filter yith_wcbr_product_filter_by_brand_args
* Dev: added yith_wcbr_get_terms_args filter

= 1.3.0 - Released on 17 December 2018 =

* New: WordPress 5.0 support
* New: WooCommerce 3.5.2 support
* New: added Gutenberg blocks for plugin shortcodes
* New: added pagination param to Brand Thumbnail widget
* Update: dutch language
* Fix: hide empty filter not being removed after get_terms
* Dev: added filter yith_wcbr_thumbnail_carrousel_shortcode_atts

= 1.2.4 - Released on 24 October 2018 =

* New: added WooCommerce 3.5 support
* Tweak: updated plugin framework
* Tweak: fixed default values for VC shortcodes

= 1.2.3 - Released on 09 October 2018 =

* New: added WordPress 4.9.8 support
* New: added WooCommerce 3.5-RC support
* New: updated plugin framework
* Tweak: adding per page brands to the YITH Brand Thumbnail wigdet
* Tweak: two new parameters for widgets YITH Brands List (order / order by)
* Update: Italian language
* Update: Dutch language
* Fix: tax_query in brand shortcode
* Fix: term sorting for filter shortcode
* Dev: added yith_wcbr_sort_label filter to change Sort by brand label
* Dev: added yith_wcbr_taxonomy_label_name filter to change brands taxonomy name
* Dev: added yith_wcbr_show_sort_by_brand filter
* Dev: added yith_wcbr_set_sort_by_brand filter

= 1.2.2 - Released on 28 May 2018 =

* New: WooCommerce 3.4 compatibility
* New: WordPress 4.9.6 compatibility
* New: updated plugin framework
* New: GDPR compliance
* New: added new importer to let admin import product/brand connections when they already have brands set up and just want to associate them to related products
* New: added loop param to carousel shortcodes
* Tweak: updated Swiper Slider to 4.2.2
* Tweak: Improved support to YITH themes
* Update: Italian Language
* Update: Spanish Language
* Fix: fixed brand parameter for shortcodes
* Dev: added yith_wcbr_brand_thumbnail_carousel_time filter

= 1.2.1 - Released on 08 February 2018 =

* New: WooCommerce 3.3.1 compatibility
* New: WordPress 4.9.4 compatibility
* New: added auto-sense brand parameter for Brand Products and Brand Products Slider shortcodes
* Tweak: Improved auto-sense category param to work also on product page
* Fix: preventing notice "Trying to get property from non-object" on terms sorting function

= 1.2.0 - Released on 08 January 2018 =

* New: WooCommerce 3.2.6 compatibility
* New: added compatibility with WC Importer/Exporter
* New: updated plugin-fw to 3.0
* New: added option to set rewrite for default brand taxonomy
* New: added Tools panel
* Tweak: added missing params to widgets, to match shortcodes ones
* Tweak: improved js handling for Brand Select shortcode / widget
* Tweak: added do_shortcode to brand description
* Fix: problem with default WooCommerce sorting when "Sort by brand" is enabled
* Fix: Sort by brand causing "No product matching your selection" error on category page
* Dev: added yith_wcbr_taxonomy_object_type filter to let third party code to change post type taxonomy is created for (use it at your own risk)

= 1.1.1 - Released on 11 April 2017 =

* New: WooCommerce 3.0.1 compatibility
* Fix: terms meta query overwritten by "sorting" method
* Fix: preventing notice when crop is not set for image sizes
* Fix: brand param for Brand Grid shortcode

= 1.1.0 - Released on 04 April 2017 =

* New: WordPress 4.7.3 compatibility
* New: WooCommerce 3.0.0 compatibility
* New: Categories field for product shortcode in VC
* New: Sorting categories on Brand Grid Shortcode (by name)
* New: admin can sort brands with Drag & Drop
* New: now terms are retrieved using default ordering (menu ordering)
* New: added shortcode yith_wcbr_product_brand to print brands of a specific product
* Tweak: added wpautop to brand description
* Tweak: removed _usort_terms_by_ID (WP 4.7 compatibility)
* Tweak: improved per brand filter on product page (changed filter name to avoid issue with WooCommerce Brands)
* Tweak: changed description container from p to div
* Tweak: changed sort algorithm for terms in brands_grid and brands_filter shortcodes
* Tweak: Check over "cb" column existence for taxonomy view
* Tweak: now terms sorting is case insensitive
* Tweak: added compatibiity with YIT Layout
* Fix: added "Brands" column when using attributes as brand taxonomy
* Fix: Brand/Category relationship method won't produce only last category anymore
* Dev: added yith_wcbr_taxonomy_labels filter, to let customers change taxonomy labels
* Dev: added yith_wcbr_brand_filter_terms filter, to let developers change shortcode term sorting
* Dev: added yith_wcbr_remove_brand_header_on_next_pages filter to show brand header on each archive page
* Dev: added action yith_wcbr_before_shortcode
* Dev: added actionyith_wcbr_after_shortcode
* Dev: added filter yith_wcbr_taxonomy_slug to customize taxonomy slug (use it at your own risk, as changing taxonomy slug will remove all terms and product associations)

= 1.0.9 - Released on 28 November 2016 =

* Add: rewrite for brand in products url
* Add: per page value to Brand Thumbnail Widget
* Add: category param to yith_wcbr_brand_product_carousel and yith_wcbr_brand_product shortcodes
* Add: filter on product post type page
* Add: spanish translation
* Tweak: improved terms sorting in brand_filter and brand_grid shortcodes
* Tweak: extended get_brand_category_relationships to category children
* Tweak: changed pagination for brand_thumbnail shortcode: now per page is used even if no pagination is set
* Tweak: changed text doamin to yith-woocommerce-brands-add-on
* Dev: added yith_wcbr_brand_filter_heading_letters filter, to let third party dev add non ascii characters
* Dev: added yith_wcbr_brand_filter_heading_letter filter, to let dev filter brand heading letter
* Dev: added yith_wcbr_product_taxonomies filter, to let developers add custom product taxonomies
* Dev: added yith_wcbr_taxonomy_labels filter to let dev customize taxonomy labels
* Fixed: inconsistency with count number when "hide out of stock products" options is enabled
* Fixed: missing php tags for navigation on brand_filter.php template
* Fixed: filter per brand behaviour (products admin page)


= 1.0.8 - Released on 13 June 2016 =

* Fixed: removed "meta_query" from get_terms when WC < 2.6

= 1.0.7 - Released on 10 June 2016 =

* Added: WordPress 4.5.2 support
* Added: WooCommerce 2.6-RC1 support
* Tweak: deprecated function that refers directly to woocommerce_termmeta
* Tweak: added meta_query in get_terms to filter brands without image
* Tweak: added yith_wcbr_get_terms to pass different params to get_terms for WP > 4.5
* Fixed: hide_no_image flag in Brand Thumbnail Carousel and Brand Thumbnail widgets
* Fixed: admin filed css issue (line height for image size)

= 1.0.6 - Released on 02 May 2016 =

* Added: WordPress 4.5.1 support
* Added: WooCommerce 2.5.5 support
* Added: options to set brands thumb dimensions
* Added: "Before product title" position for single product brand
* Added: flag with_front on register_taxonomy, with filter yith_wcbr_taxonomy_with_front to change default value
* Added: Rich Snippets for brand
* Added: Integration with YOAST Seo (%%product_brand%% for products)
* Added: fix for WCAN (adding .yit-wcan-container in swiper carousel)
* Added: filter yith_customize_product_carousel_loop to customize $woocommerce_loop before product carousel
* Added: filter yith_wcbr_print_brand_description to hide product brand description
* Added: filter yith_wcbr_taxonomy_label for brand label
* Added: transients yith_wcbr_brand_category_relationships and yith_wcbr_category_brand_relationships to improve performance of shortcodes callbacks
* Tweak: updated Swiper library to revision 3.3.0
* Fixed: error including assets on backend caused by wrong screen id

= 1.0.5 - Released on 23 October 2015 =

* Tweak: Performance improved with new plugin core 2.0
* Fixed: plugin-fw breaking theme-editor.php page

= 1.0.4 - Released on 21 September 2015 =

* Added: yith_wcbr_taxonomy_capabilities filter
* Added: YITH WooCommerce Multi Vendor Support
* Fixed: "All" placeholder disappearing on select2 dropdown

= 1.0.3 - Released on 13 August 2015 =

* Added: Compatibility with WC 2.4.2
* Tweak: Updated internal plugin-fw

= 1.0.2 - Released on 13 July 2015 =

* Added: WC 2.3.13 support
* Added: improved YITH WooCommerce Product Filter compatibility
* Fixed: minor bugs

= 1.0.1 - Released on 18 June 2015 =

* Initial release