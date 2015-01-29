#!/usr/bin/env
'''Non SQL based event sorting that sorts '''

__version__ = 1.0
__date__ = '2015-01-12'
__author__ = ['Mengdi Lin <ml3567@columbia.edu >', 'Konstantin Itskov <konstantin.itskov@kovits.com>']

import os, json, sys, calendar, argparse
from datetime import datetime, timedelta
import heapq

def main():
    formatter = lambda prog: argparse.HelpFormatter(prog, max_help_position = 40, width = 132)
    parser = argparse.ArgumentParser(prog = "events", formatter_class = formatter, add_help = False, description = 'Sorts event files and outputs the ones coming up.')
    parser.add_argument("-n", "--num", type = int, default = 5, help = "Specifies the number of outputs to return")
    parser.add_argument("-l", "--loc", default = ".", help = "Number of output")
    parser.add_argument("-h", "--help", action = "help", help = argparse.SUPPRESS)

    subparser = parser.add_subparsers(dest = 'command')
    # Sub parser for sorting events
    parser = subparser.add_parser('events', formatter_class = self.formatter, add_help = False, description = 'Remove from data list.', help = 'remove from data list')
    parser.add_argument("-h", "--help", action = "help", help = argparse.SUPPRESS)
    parser.add_argument("-d", metavar = "date", action = "store_true" default = False, help = "Sorts the input based on the date")
    # Sub parser for sorting images
    parser = subparser.add_parser('images', formatter_class = self.formatter, add_help = False, description = 'Push data based to the server.', help = 'push data based to the server')
    parser.add_argument("-h", "--help", action = "help", help = argparse.SUPPRESS)
    parser.add_argument('-idx', '--index', metavar = '', type = int, help = 'index of the datum to push to the server')

    args = parser.parse_args()
    print args
    return


    current_time = calendar.timegm(time.gmtime())
    sort_var = sys.argv[4]
    #get all filenames in current dir
    files = [f for f in os.listdir(args.loc) if os.path.isfile(f)]

    if args.date:
        filename.endswith(".evnt")
    files = [f for f in files if f != 'sort.py']

    # h is the heap with size num_file
    h = []
    for f in files[:args.num]:
        #print f
        json_data = open(f)
        data = json.load(json_data)
        #print data[sort_var]
        #stores a tuple of (diff of event_time, file_name) to heap
        heappush(h, (current_time-data[sort_var], f))
        json_data.close()
    for f in files[args.num:]:
        #print f
        json_data = open(f)
        data = json.load(json_data)
        #print data[sort_var]
        heappush(h, (current_time-data[sort_var], f))
        heappop(h);
        json_data.close()

    sorted_event = []
    for i in range(len(h)):
        sorted_event.append(heappop(h)[1]);
    print sorted_event

if __name__ == "__main__":
    main()
