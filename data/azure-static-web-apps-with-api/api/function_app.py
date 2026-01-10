import azure.functions as func

app = func.FunctionApp()

@app.route(route='bookmarks', methods=['GET'], auth_level=func.AuthLevel.ANONYMOUS)
def handle_list_bookmarks(req: func.HttpRequest) -> func.HttpResponse:
    try:
        # verify_request(req)
        # keyword = req.params.get('keyword')
        # if keyword is None:
        #     bookmarks = list_bookmarks()
        #     return ListResponse(items=bookmarks).ok()
        bookmarks = search_bookmarks(keyword)
        return func.HttpResponse(bookmarks.model_dump_json(), mimetype='application/json', status_code=200)
    except Exception as e:
        return func.HttpResponse('{}', mimetype='application/json', status_code=400)
