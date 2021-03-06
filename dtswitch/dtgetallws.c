
/* include files  */
#include <stdio.h>
#include <stdlib.h>
#include <Xm/Xm.h>
#include <Dt/Dt.h>
#include <Dt/Wsm.h>

/* global variables  */
static Widget toplevel;
static Display *display;
static int screen;
static Window root;

static XtAppContext app_context;
static Arg args[10];
int n;

static int pNumWorkspaces;
static Atom *ppaWorkspaces;
static int i;

/* main - main logic for program */
void main(int argc, char **argv) {
	/* initialize toolkit */
	toplevel=XtAppInitialize(&app_context, "Dtswitch", NULL, 0, &argc, argv, NULL, args, n);
	display=XtDisplay(toplevel);
	screen=DefaultScreen(display);
	root=RootWindow(display, screen);

	DtWsmGetWorkspaceList(display,root,&ppaWorkspaces,&pNumWorkspaces);
	for(i=0;i<pNumWorkspaces;i++) {
		if(i>0) printf(",");
		printf("%d",ppaWorkspaces[i]);
	}
	printf("\n");
}
