#!/usr/bin/env python
"""Non SQL based event sorting that sorts."""

import os
import json
import sys
import calendar
import argparse
from datetime import datetime, timedelta
import heapq
import pprint

__version__ = 1.0
__date__ = '2015-01-12'
__author__ = ('Mengdi Lin <ml3567@columbia.edu >', 'Konstantin Itskov <konstantin.itskov@kovits.com>')


def main():
    """Main execution function of this sorting software."""
    formatter = lambda prog: argparse.HelpFormatter(prog, max_help_position=40, width=132)
    prog_parser = argparse.ArgumentParser(prog="sort", formatter_class=formatter, add_help=False, description='Sorts object files and prints the sort results.')
    prog_parser.add_argument("-n", "--num", dest="num", metavar="", type=int, default=3, help="Specifies the number of outputs to return")
    prog_parser.add_argument("-h", "--help", action="help", help=argparse.SUPPRESS)
    subparser = prog_parser.add_subparsers(dest='command')
    # Sub parser for sorting events
    parser = subparser.add_parser('events', formatter_class=formatter, add_help=False, description='Sorts among events.', help='sorts among events')
    parser.add_argument("-h", "--help", action="help", help=argparse.SUPPRESS)
    parser.add_argument("-l", "--loc", dest="loc", metavar="", default="events/", help="Specifies the directory inside which events reside")
    parser.add_argument("-d", "--date", dest="date", action="store_true", default=False, help="Sorts the input based on the date")
    # Sub parser for sorting images
    parser = subparser.add_parser('images', formatter_class=formatter, add_help=False, description='Sorts among images.', help='sorts among images')
    parser.add_argument("-h", "--help", action="help", help=argparse.SUPPRESS)
    parser.add_argument("-l", "--loc", dest="loc", metavar="", default="images/", help="Specifies the directory inside which images reside")
    args = prog_parser.parse_args()

    # get all filenames in current dir
    files = [f for f in os.listdir(args.loc) if os.path.isfile(args.loc + f)]
    if args.command == "events":
        if args.date:
            files = [f for f in files if f.endswith(".evnt")]
        else:
            files = []
    elif args.command == "images":
        pass
    else:
        raise Exception("!(args.command)")

    upq = []
    rpq = []
    queue = []
    mode = 0
    for filename in files:
        fd = open(args.loc + filename)
        data = json.loads(fd.read())
        fd.close()
        data['filename'] = filename

        if args.command == "events":
            if args.date:
                start_dt = datetime.strptime(data['start_datetime'], "%Y-%m-%d %H:%M:%S")
                end_dt = datetime.strptime(data['end_datetime'], "%Y-%m-%d %H:%M:%S")
                epoch = datetime.utcfromtimestamp(0)
                start_ddt = start_dt - epoch
                end_ddt = end_dt - epoch
                now_ddt = datetime.now() - epoch

                if now_ddt > start_ddt and now_ddt < end_ddt:
                    heapq.heappush(upq, (start_ddt.total_seconds(), json.dumps(data)))
                elif now_ddt <= start_ddt:
                    heapq.heappush(upq, (start_ddt.total_seconds(), json.dumps(data)))
                else:
                    heapq.heappush(rpq, (end_ddt.total_seconds() * -1, json.dumps(data)))

        elif args.command == "images":
            pass

    while len(upq):
        queue.append(heapq.heappop(upq)[1])

    while len(rpq):
        queue.append(heapq.heappop(rpq)[1])

    for i in range(3):
        print queue[i]

if __name__ == "__main__":
    main()
