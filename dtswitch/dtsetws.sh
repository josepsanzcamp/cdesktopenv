#!/usr/dt/bin/dtksh
exec 2>/dev/null

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmAddCurrentWorkspaceCallback handle $TOP ""
DtWsmSetCurrentWorkspace $TOP $1
XFlush $display

