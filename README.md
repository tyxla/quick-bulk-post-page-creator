Quick Bulk Post & Page Creator
==============================

## About

A handy WordPress plugin for batch creation of posts and pages in your preferred hierarchy. Indispensable tool for WordPress developers.

## Getting Started

After installing and activating the plugin, go to Tools -> Quick Post Creator. Please, refer to the Usage section below for usage information and examples.

## Usage

When you go to Tools -> Quick Post Creator, you will find a form with the following fields:

#### Hierarchy Indent Character
Specifies the character (or set of characters) that are used to specify the hierarchy indentation. You can use those characters in your Entries text, prepending one or more entries with one or more of these characters. You can read more about how this field is used in the "Entries" field description below.

#### Post Type
Specifies the post type of the entries that you want to bulk create.

#### Post Status
Specifies the post status of the entries that you want to bulk create.

#### Entries
Allows you to insert as many titles of entries as you wish. Each entry should be on a separate line. You can additionally prepend each entry with one or more hierarchy indent characters. For example, if your character is an asterisk - `*`, you can use one asterisk at the beginning of an entry to specify that it is a child of the last item without any asterisks. You can use 2 asterisks at the beginning of an entry to specify that it is a child of the last item with 1 asterisk, and so on. There is no limit of how deep you can go with your hierarchy. Also, there is no limit of the number of entries that you might want to bulk create. 

## Examples

#### Example 1

The following example will create 5 published posts with the corresponding titles.

* Hierarchy Indent Character: `*`
* Post Type: `Posts`
* Post Status: `Publish`
* Entries: 

```
Post 1
Post 2
Post 3
Post 4
Post 5
```

#### Example 2

The following example will create 5 published pages with the corresponding titles and the specified hierarchy (X1, X2 as a child of X, X1a as a child of X1 and X2, X and Y as parents).

* Hierarchy Indent Character: `-`
* Post Type: `Pages`
* Post Status: `Publish`
* Entries: 

```
Page X
- Page X1
-- Page X1a
- Page X2
Page Y
```

## Ideas and bug reports

Any bug reports or ideas for new functionality that users would benefit from are welcome. 

If you have an idea for a new feature, or you want to report a bug, feel free to do it in the WordPress Plugin Directory Support tab, or you can do it here at repository. 