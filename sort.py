#!/usr/bin/env
import os, json, sys, calendar, time, datetime
from heapq import heappush, heappop

def sort_event():
    current_time = calendar.timegm(time.gmtime())
    num_file = int(sys.argv[2])
    sort_var = sys.argv[4]
    #get all filenames in current dir
    files = [f for f in os.listdir('.') if os.path.isfile(f)]
    files = [f for f in files if f != 'sort.py']

    # h is the heap with size num_file
    h = []
    for f in files[:num_file]:
        #print f
        json_data = open(f)
        data = json.load(json_data)
        #print data[sort_var]
        #stores a tuple of (diff of event_time, file_name) to heap
        heappush(h, (current_time-data[sort_var], f))
        json_data.close()
    for f in files[num_file:]:
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
    sort_event()
