<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
</style>
<div class="ui-widget">
    <label>Select a school: </label>
    <select id="schoolList" class="convertToComboBox">
      <option value="0"></option>
      <option value="1">DPS</option>
      <option value="2">APS</option>
      <option value="3">LVM</option>
      <option value="4">Jain International</option>
      <option value="5">Don Bosco</option>
    </select>
</div>