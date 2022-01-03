<?php
/*
 * Constants
 */

CONST BAD_REQUEST = 'BAD_REQUEST';
CONST INVALID_TOKEN = 'INVALID_TOKEN';
CONST UNAUTHORISED = 'UNAUTHORISED';
CONST API_ERROR = 'API_ERROR';
CONST VALIDATION_ERROR = 'VALIDATION_ERROR';

CONST GLOBAL_REASON = 'global.reason';
const REQ = 'required';
const REQ_INT = 'required|integer';
CONST UPDATE = 'update';
CONST NO_UPDATE = 0;
CONST NORMAL_UPDATE = 1;
CONST FORCE_UPDATE = 2;
CONST ACTIVE = 1;
CONST INACATIVE = 0;

return [
	'process' => [
		'ShiftMasterController' => [
			'id' => 17,
			'name' => 'cadre',
		],
	],
	'visible_process_status_ids' => [ // proces_status_ids which are visible to user on landing screens
		'reviewer' => [2, 3, 6, 9],
		'approver' => [8, 4, 5, 6, 9, 10],
	],
];
