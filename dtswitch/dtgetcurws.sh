#!/usr/dt/bin/dtksh

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmGetCurrentWorkspace $display $root workspace
XmGetAtomName name $display $workspace
echo $workspace"|"$name

