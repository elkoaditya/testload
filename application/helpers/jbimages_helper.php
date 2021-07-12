<?php

/*
  This Helper is a wrapper of the file below
 */

function is_allowed() {
	return user_role('#login');
}

