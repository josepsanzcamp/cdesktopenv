#!/usr/dt/bin/dtksh
exec 2>/dev/null

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmSetWorkspacesOccupied $display $1 $2
XFlush $display

