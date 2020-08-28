#!/usr/dt/bin/dtksh
exec 2>/dev/null

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmGetCurrentWorkspace $display $root workspace
XmGetAtomName name $display $workspace
echo $workspace"|"$name

