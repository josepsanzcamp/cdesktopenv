#!/usr/dt/bin/dtksh

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmGetWorkspaceList $display $root workspaces
for workspace in $(echo $workspaces | tr ',' ' '); do
	XmGetAtomName name $display $workspace
	echo $workspace"|"$name
done

