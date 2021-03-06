<?php
/**
 * @file
 * Template file for the XSD file generated by the Islandora Feeds module.
 * 
 * Available variables:
 *   $documentation string
 *     A string describing what software generated the XSD and when.
 *   $content_type string
 *     The content type the schema is based on.
 *   $fields array
 *     A list of all the fields in the content type.
 */
?>
<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <xsd:annotation>
    <xsd:documentation xml:lang="en">
      <?php print $documentation; ?>
    </xsd:documentation>
  </xsd:annotation>

  <!-- The content type's machine name. -->
  <xsd:element name="<?php print $content_type; ?>" type="<?php print $content_type; ?>"/>

  <?php if (count($fields)): ?>
    <!-- Each field in the content type gets an xsd:element. -->
    <xsd:complexType name="<?php print $content_type; ?>">
      <xsd:sequence>
       <?php foreach ($fields as $field): ?>
       <xsd:element name="<?php print $field; ?>" type="xsd:string"/>
       <?php endforeach; ?>
      </xsd:sequence>
       <xs:attribute name="label" type="xsd:string"/>
    </xsd:complexType>
  <?php endif; ?>

</xsd:schema>
