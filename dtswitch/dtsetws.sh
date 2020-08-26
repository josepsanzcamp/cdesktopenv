#!/usr/dt/bin/dtksh

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmAddCurrentWorkspaceCallback handle $TOP ""
DtWsmSetCurrentWorkspace $TOP $1
XFlush $display

