#!/usr/dt/bin/dtksh

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmSetWorkspacesOccupied $display $1 $2
XFlush $display

