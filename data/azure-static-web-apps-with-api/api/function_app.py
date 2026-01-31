import azure.functions as func
import json

app = func.FunctionApp()

# see https://learn.microsoft.com/ja-jp/azure/azure-functions/functions-reference-python
@app.route(route='info', methods=['GET'], auth_level=func.AuthLevel.ANONYMOUS)
def handle_get_info(req: func.HttpRequest) -> func.HttpResponse:
    try:
        data = {
            'version': 'v0.0.1',
            'message': 'Hello from azure functions',
        }
        return func.HttpResponse(
            body=json.dumps(data),
            mimetype='application/json',
            status_code=200,
        )
    except Exception as e:
        return func.HttpResponse(
            body=str(e),
            status_code=400,
        )
