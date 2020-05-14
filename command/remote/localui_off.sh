#!/bin/bash

export DISPLAY=:0

WAKE_DISPLAY=$(sqlite3 $SQL_DB "SELECT value FROM cfg_system WHERE param='wake_display'")
if [[ $WAKE_DISPLAY = "1" ]]; then
    xset s reset
else
    xset s activate
fi