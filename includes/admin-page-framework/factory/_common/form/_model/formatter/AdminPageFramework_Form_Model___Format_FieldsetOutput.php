<?php 
/**
	Admin Page Framework v3.8.1 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/omniweb-showtimes>
	Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class OmniwebShowtimes_AdminPageFramework_Form_Model___Format_Fieldset extends OmniwebShowtimes_AdminPageFramework_Form_Model___Format_FormField_Base {
    static public $aStructure = array('field_id' => null, 'section_id' => null, 'type' => null, 'section_title' => null, 'page_slug' => null, 'tab_slug' => null, 'option_key' => null, 'class_name' => null, 'capability' => null, 'title' => null, 'tip' => null, 'description' => null, 'error_message' => null, 'before_label' => null, 'after_label' => null, 'if' => true, 'order' => null, 'default' => null, 'value' => null, 'help' => null, 'help_aside' => null, 'repeatable' => null, 'sortable' => null, 'show_title_column' => true, 'hidden' => null, 'placement' => 'normal', 'attributes' => null, 'class' => array('fieldrow' => array(), 'fieldset' => array(), 'fields' => array(), 'field' => array(),), 'save' => true, 'content' => null, '_fields_type' => null, '_structure_type' => null, '_caller_object' => null, '_section_path' => '', '_section_path_array' => '', '_nested_depth' => 0, '_subsection_index' => null, '_section_repeatable' => false, '_is_section_repeatable' => false, '_field_path' => '', '_field_path_array' => array(), '_parent_field_path' => '', '_parent_field_path_array' => array(), '_is_title_embedded' => false,);
    public $aFieldset = array();
    public $sStructureType = '';
    public $sCapability = 'manage_options';
    public $iCountOfElements = 0;
    public $iSubSectionIndex = null;
    public $bIsSectionRepeatable = false;
    public $oCallerObject;
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aFieldset, $this->sStructureType, $this->sCapability, $this->iCountOfElements, $this->iSubSectionIndex, $this->bIsSectionRepeatable, $this->oCallerObject);
        $this->aFieldset = $_aParameters[0];
        $this->sStructureType = $_aParameters[1];
        $this->sCapability = $_aParameters[2];
        $this->iCountOfElements = $_aParameters[3];
        $this->iSubSectionIndex = $_aParameters[4];
        $this->bIsSectionRepeatable = $_aParameters[5];
        $this->oCallerObject = $_aParameters[6];
    }
    public function get() {
        $_aFieldset = $this->uniteArrays(array('_fields_type' => $this->sStructureType, '_structure_type' => $this->sStructureType, '_caller_object' => $this->oCallerObject, '_subsection_index' => $this->iSubSectionIndex,) + $this->aFieldset, array('capability' => $this->sCapability, 'section_id' => '_default', '_section_repeatable' => $this->bIsSectionRepeatable, '_is_section_repeatable' => $this->bIsSectionRepeatable,) + self::$aStructure);
        $_aFieldset['field_id'] = $this->getIDSanitized($_aFieldset['field_id']);
        $_aFieldset['section_id'] = $this->getIDSanitized($_aFieldset['section_id']);
        $_aFieldset['_section_path'] = $this->getFormElementPath($_aFieldset['section_id']);
        $_aFieldset['_section_path_array'] = explode('|', $_aFieldset['_section_path']);
        $_aFieldset['_field_path'] = $this->_getFieldPath($_aFieldset);
        $_aFieldset['_field_path_array'] = explode('|', $_aFieldset['_field_path']);
        $_aFieldset['order'] = $this->getAOrB(is_numeric($_aFieldset['order']), $_aFieldset['order'], $this->iCountOfElements + 10);
        $_aFieldset['class'] = $this->getAsArray($_aFieldset['class']);
        if ($this->hasFieldDefinitionsInContent($_aFieldset)) {
            $_aFieldset['content'] = $this->_getChildFieldsetsFormatted($_aFieldset['content'], $_aFieldset);
        }
        if ($this->hasNestedFields($_aFieldset)) {
            $_aFieldset['type'] = '_nested';
        }
        $_aFieldset['_is_title_embedded'] = $this->_isTitleEmbedded($_aFieldset);
        return $_aFieldset;
    }
    private function _isTitleEmbedded(array $aFieldset) {
        if ('section_title' === $aFieldset['type']) {
            return true;
        }
        if ('normal' !== $aFieldset['placement']) {
            return true;
        }
        return false;
    }
    private function _getFieldPath(array $aFieldset) {
        return $this->getTrailingPipeCharacterAppended($aFieldset['_parent_field_path']) . $this->getFormElementPath($aFieldset['field_id']);
    }
    private function _getChildFieldsetsFormatted(array $aNestedFieldsets, array $aParentFieldset) {
        $_aInheritingFieldsetValues = array('section_id' => $aParentFieldset['section_id'], 'section_title' => $aParentFieldset['section_title'], 'placement' => $aParentFieldset['placement'], 'page_slug' => $aParentFieldset['page_slug'], 'tab_slug' => $aParentFieldset['tab_slug'], 'option_key' => $aParentFieldset['option_key'], 'class_name' => $aParentFieldset['class_name'], 'capability' => $aParentFieldset['capability'], '_structure_type' => $aParentFieldset['_structure_type'], '_caller_object' => $aParentFieldset['_caller_object'], '_section_path' => $aParentFieldset['_section_path'], '_section_path_array' => $aParentFieldset['_section_path_array'], '_subsection_index' => $aParentFieldset['_subsection_index'],);
        foreach ($aNestedFieldsets as $_isIndex => & $_aNestedFieldset) {
            if (is_scalar($_aNestedFieldset)) {
                $_aNestedFieldset = array('field_id' => $aParentFieldset['field_id'] . '_' . uniqid(), 'content' => $_aNestedFieldset,);
            }
            $_aNestedFieldset['_parent_field_path'] = $aParentFieldset['_field_path'];
            $_aNestedFieldset['_parent_field_path_array'] = explode('|', $aParentFieldset['_parent_field_path']);
            $_aNestedFieldset['_nested_depth'] = $aParentFieldset['_nested_depth'] + 1;
            $_oFieldsetFormatter = new OmniwebShowtimes_AdminPageFramework_Form_Model___Format_Fieldset($_aNestedFieldset + $_aInheritingFieldsetValues, $this->sStructureType, $this->sCapability, $this->iCountOfElements, $this->iSubSectionIndex, $this->bIsSectionRepeatable, $this->oCallerObject);
            $_aNestedFieldset = $_oFieldsetFormatter->get();
        }
        return $aNestedFieldsets;
    }
}
class OmniwebShowtimes_AdminPageFramework_Form_Model___Format_FieldsetOutput extends OmniwebShowtimes_AdminPageFramework_Form_Model___Format_Fieldset {
    static public $aStructure = array('_section_index' => null, 'tag_id' => null, '_tag_id_model' => '', '_field_name' => '', '_field_name_model' => '', '_field_name_flat' => '', '_field_name_flat_model' => '', '_field_address' => '', '_field_address_model' => '', '_parent_field_object' => null, '_parent_tag_id' => null,);
    public $aFieldset = array();
    public $iSectionIndex = null;
    public $aFieldTypeDefinitions = array();
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aFieldset, $this->iSectionIndex, $this->aFieldTypeDefinitions,);
        $this->aFieldset = $_aParameters[0];
        $this->iSectionIndex = $_aParameters[1];
        $this->aFieldTypeDefinitions = $_aParameters[2];
    }
    public function get() {
        $_aFieldset = $this->aFieldset + self::$aStructure;
        $_aFieldset['_section_index'] = $this->iSectionIndex;
        $_oFieldTagIDGenerator = new OmniwebShowtimes_AdminPageFramework_Form_View___Generate_FieldTagID($_aFieldset, $_aFieldset['_caller_object']->aCallbacks['hfTagID']);
        $_aFieldset['tag_id'] = $_oFieldTagIDGenerator->get();
        $_aFieldset['_tag_id_model'] = $_oFieldTagIDGenerator->getModel();
        $_oFieldNameGenerator = new OmniwebShowtimes_AdminPageFramework_Form_View___Generate_FieldName($_aFieldset, $_aFieldset['_caller_object']->aCallbacks['hfName']);
        $_aFieldset['_field_name'] = $_oFieldNameGenerator->get();
        $_aFieldset['_field_name_model'] = $_oFieldNameGenerator->getModel();
        $_oFieldFlatNameGenerator = new OmniwebShowtimes_AdminPageFramework_Form_View___Generate_FlatFieldName($_aFieldset, $_aFieldset['_caller_object']->aCallbacks['hfNameFlat']);
        $_aFieldset['_field_name_flat'] = $_oFieldFlatNameGenerator->get();
        $_aFieldset['_field_name_flat_model'] = $_oFieldFlatNameGenerator->getModel();
        $_oFieldAddressGenerator = new OmniwebShowtimes_AdminPageFramework_Form_View___Generate_FieldAddress($_aFieldset);
        $_aFieldset['_field_address'] = $_oFieldAddressGenerator->get();
        $_aFieldset['_field_address_model'] = $_oFieldAddressGenerator->getModel();
        $_aFieldset = $this->_getMergedFieldTypeDefault($_aFieldset, $this->aFieldTypeDefinitions);
        if ($this->hasFieldDefinitionsInContent($_aFieldset)) {
            foreach ($_aFieldset['content'] as & $_aNestedFieldset) {
                if (is_scalar($_aNestedFieldset)) {
                    continue;
                }
                $_oFieldsetOutputFormatter = new OmniwebShowtimes_AdminPageFramework_Form_Model___Format_FieldsetOutput($_aNestedFieldset, $this->iSectionIndex, $this->aFieldTypeDefinitions);
                $_aNestedFieldset = $_oFieldsetOutputFormatter->get();
            }
        }
        return $_aFieldset;
    }
    private function _getMergedFieldTypeDefault(array $aFieldset, array $aFieldTypeDefinitions) {
        return $this->uniteArrays($aFieldset, $this->getElementAsArray($aFieldTypeDefinitions, array($aFieldset['type'], 'aDefaultKeys'), array()));
    }
}
