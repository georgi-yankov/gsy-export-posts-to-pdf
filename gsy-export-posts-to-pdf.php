<?php

/*
 * Plugin Name: GSY Export Posts to PDF
 * Plugin URI: https://github.com/georgi-yankov/gsy-export-posts-to-pdf
 * Description: Export posts to pdf.
 * Version: 1.0
 * Author: Georgi Yankov
 * Author URI: http://gsy-design.com
 * Text Domain: gsy-export-posts-to-pdf
 * License: GPLv2
 */

/* Copyright 2014 Georgi Yankov (email : georgi.st.yankov@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

require_once 'includes/class-gsy-export-posts-to-pdf.php';

$gsy_export_posts_to_pdf = new GSY_Export_Posts_To_Pdf();
load_plugin_textdomain('gsy-export-posts-to-pdf', false, plugin_basename(dirname(__FILE__) . '/localization/'));