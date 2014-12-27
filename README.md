# Islandora Feeds Importer

## Introduction

This module allows users to create Islandora objects using the Feeds contrib module. Still under development, so use cases are welcome.

## Requirements

[Feeds](https://drupal.org/project/feeds)

## Installation

Install as usual, see [this](https://drupal.org/documentation/install/modules-themes/modules-7) for further information.

## Usage

### Overview

This module provides a Feeds processor that creates Islandora objects. Currently, the only datastream that is created is a managed XML datastream (with the datastream ID of 'OBJ') that contains elements mirroring the column headings in CSV files (or equivalent in other input formats) you are loading using Feeds, with element values that correspond to the values in the columns.

For example, given a CSV file like this as input:

```
Title, Field 1, Field 2
"First title","First item's field 1 value", "First item's field 2 value"
"Second title","Second item's field 1 value", "Second item's field 2 value"
"Third title","Third item's field 1 value", "Third item's field 2 value"
```
the module ingests Islandora objects, one per row of the CSV, each with an OBJ datastream that looks like:

```xml
<?xml version="1.0" encoding="UTF-8"?>
  <fielddata>
     <title label="Title">First title</title>
     <field_1 label="Field 1">First item's field 1 value</field_1>
     <field_2 label="Field 2"> First item's field 2 value</field_2>
</fielddata>
```

Islandora Feeds uses a version of the Feeds Node processor to create a node for each item you are importing. Each node then serves as the source of the Islandora object that is created. You have the option of saving these nodes (for quality assurance) or deleting them immediately after the Islandora object is created. You also have the option of importing the data into nodes but creating the corresponding Islandora objects later, using Views Bulk Operations.

The specific elements in the OBJ datastream are defined in a Drupal content type. You need to create a Drupal content type that contains all the fields corresponding to the data in your incoming Feed source and then map the incoming data to those fields using the standard tool provided by Feeds. The nodes created during the import are instances of this content type, and each node generates a corresponding Islandora object. All objects created by this module share a single Islandora content model (Islandora Feeds Content Model / islandora:feedsCModel), but the XML datastreams generated by the module (whether via a Feeds import or via add/edit forms created by the XML Forms Builder) can vary across collections; that is, all the objects within the same Islandora collection can share the same field definition.

### Creating objects

First, create a Drupal content type containing the fields that you want to have in your OBJ XML datastreams. The element names will correspond to the content type field names minus the "field_" that Drupal adds (for example, a content type field with the machine name "field_my_first_field" will create a ```<my_first_field>``` element in your OBJ datastream). All your fields should be of type 'text' and use the 'textfield' widget.

After you have created your content type, configure your Feed importer by going to Structure > Feeds importers > Add importer and create a new importer. Attach your content type to the importer. Then edit the importer. The only settings you need to configure are the Processor settings. Under the Processor settings, select the Islandora Feeds node processor, and save. Then in the Processor Mappings, map the fields in your CSV (or similar) source to fields in your target content type.

Be sure to select the correct Islandora content model (which should be "Islandora Feeds Content Model") and target collection. Also choose whether you want to create the objects during the import or later, and whether you want to delete the nodes. Note that these nodes do not have any relationship to the objects ingested into Fedora after the objects are created - they are only used as the source of the ingest and are not synchronized with the objects after the import. 

You should map one of the fields in your source to Title in your target. The only other columns in your source you need to map are the ones you have defined in your target content type - you do not need to map any of the node properties unless you want to.

Once you have configured the importer, you're ready to import your source content like you would using any other Feeds importer.

### Adding thumbnails

If your Drupal nodes have an image field with the machine name 'field_tn', the image in this field (or the first image in the field if it repeatable) will be added to the corresponding Islandora object as a TN datastream. You can add the image to your nodes manually (via the node add/edit form) or in the feed import; if the latter, you will need to upload the images to your Drupal server to a location the feed fetcher can access it (usually the public files directory).

### Generating an XML Forms definition file and XSD Schema from your content type

If you want to create add/edit forms for your objects using the Islandora XML Forms Builder, you can use an auto-generated form definition file. You can do this by going to Structure > [your content type] > edit > Islandora Feeds. Simply copy the form schema into a file (ending in .xml) and upload it into the Form Builder. You can also dowload an XSD  Schema for your content typ on this page.

## Notes

* Mapping a source field that is a number to the title won’t work. Islandora defaults to sequential numbering as a label when you attempt it. 
* When deleting nodes, the error message suggests you’ve deleted Islandora objects. This is not correct - only the Drupal content is deleted. 

## To do

* Provide tutorial on building CRUD forms using the XML Forms Builder.
* Improve and generalize the theming of the XML when viewed.
* Add the ability to inspect/edit/etc. nodes before ingesting the objects into Fedora (mostly done; requires [Views Bulk Operations](https://drupal.org/project/views_bulk_operations))
* Figure out how to import thumbnails and additional datastreams.

## Troubleshooting/issues/feedback

Use cases are welcome. The goal of this module is to leverage as much of Feeds' built-in functionality as possible while providing the ability to load a wide range of Islandora content types. If you have any questions or comments, please post them to:

* [Islandora Group](https://groups.google.com/forum/?hl=en&fromgroups#!forum/islandora)
* [Islandora Dev Group](https://groups.google.com/forum/?hl=en&fromgroups#!forum/islandora-dev)

