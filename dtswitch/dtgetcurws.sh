#!/usr/dt/bin/dtksh
exec 2>/dev/null

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

#~ DtWsmGetCurrentWorkspace $display $root workspace
workspace=$(./dtgetcurws)
./dtatom2title $workspace

