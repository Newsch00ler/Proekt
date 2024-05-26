import self
import json
import request
import config

serializer = self.InnerSerializer(data=self.request.query_params)
serializer.is_valid(raise_exception=True)

state = {
    'type': BitrixAuthViewTypes.SIMPLE.value,
}
if 'state' in serializer.validated_data and serializer.validated_data['state']:
    state = json.loads(serializer.validated_data['state'])

HTTP_REFERER = request.META.get('HTTP_REFERER') or "/"

r = requests.get("https://int.istu.edu/oauth/token/?grant_type=authorization_code", {
    "code": serializer.validated_data['code'],
    "client_id": config.BITRIX_CLIENT_ID,
    "client_secret": config.BITRIX_SECRET_KEY,
}, verify=False)

response_data = {}

data = r.json()
if r.status_code != 200:
    # messages.add_message(request, messages.WARNING, data['error_description'])
    return redirect(HTTP_REFERER)

data = r.json()
r = requests.get(data['client_endpoint'] + 'user.info.json', {
    "auth": data['access_token'],
})
if r.status_code != 200:
    response_data['result'] = 'Failed'
    response_data['message'] = data['error_description']
    return redirect(HTTP_REFERER)

data = r.json()
result = data['result']

bitrix_user_id = result['id']
email = result['email']
user, created = User.objects.get_or_create(
    userprofile__bitrix_user_id=bitrix_user_id,
    defaults={
        "username": email,
        "last_name": result['last_name'] or "",
        "first_name": result['name'] or "",
        "email": result['email'],
    }
)

if created:
    user.userprofile.bitrix_user_id = bitrix_user_id
    user.userprofile.save()

user.userprofile.is_teacher = bool(result['is_teacher'])
user.userprofile.is_student = bool(result['is_student'])
user.userprofile.mira_id = result['mira_id'][0] if result['mira_id'] else 0
teacher_instance = Teacher.objects.filter(mir_id=user.userprofile.mira_id).first()
user.userprofile.schedule_user_id = teacher_instance.id if teacher_instance else None

user.userprofile.save()

if state['type'] == BitrixAuthViewTypes.SIMPLE.value:
    return self.default_auth_processor(state, user)
elif state['type'] == BitrixAuthViewTypes.VISIT.value:
    return self.visit_auth_processor(state, user)
else:
    return redirect("/")
